<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Interfaces\Controllers\Api\V1\PaymentControllerInterface;
use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStored;
use App\Events\PaymentRejected;
use App\Events\PaymentVerified;
use App\Facades\ApiResponse;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

//TODO validations for all
class PaymentController extends Controller implements PaymentControllerInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = Payment::paginate($request->perpage ?? 10);

        return ApiResponse::message(__('payment.messages.payment_list_found_successfully'))
            ->data(new PaymentCollection($payments))
            ->status(200)
            ->send();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        // TODO change 5 min to param

        $lastSamePayment = Payment::where([
            ['user_id', $request->user_id],
            ['amount', $request->amount],
            ['created_at', '>', Carbon::now()->subMinutes(5)]
        ])->first();

        if ($lastSamePayment) {
            throw new BadRequestHttpException(__('payment.errors.you_can_create_same_paymant_after_5_minutes'));
        }
        //TODO change currency to KEY

        $payment = Payment::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'currency' =>  $request->currency,
            'attach_file' =>  $request->attach_file,
            'payment_at' => $request->payment_at,
            'unique_id' => Helper::uniqStr(),
        ]);

        PaymentStored::dispatch($payment);

        return ApiResponse::message(__('payment.messages.payment_successfuly_created'))
            ->data(new PaymentResource($payment))
            ->status(201)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return ApiResponse::message(__('payment.messages.payment_successfuly_found'))
            ->data(new PaymentResource($payment))
            ->status(200)
            ->send();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * destroy the specified resource in storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return ApiResponse::message(__('payment.messages.payment_successfuly_deleted'))
            ->data(new PaymentResource($payment))
            ->status(200)
            ->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function reject(Payment $payment)
    {
        if ($payment->status->value != PaymentStatusEnum::Pending->value) {
            throw new BadRequestHttpException(__('payment.errors.you_can_only_decline_pending_payments'));
        }

        $payment->update([
            'status' => PaymentStatusEnum::Rejected,
            'rejected_at' => time()
        ]);

        PaymentRejected::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_rejected'))
            ->data(new PaymentResource($payment))
            ->status(200)
            ->send();
    }

    public function verify(Payment $payment)
    {
        if ($payment->status->value != PaymentStatusEnum::Pending->value) {
            throw new BadRequestHttpException(__('payment.errors.you_can_only_verify_pending_payments'));
        }
        //TODO relation of models
        DB::beginTransaction();

        $payment->lockForUpdate();
        $payment->update([
            'status' => PaymentStatusEnum::Verified,
            'verified_at' => time()
        ]);

        Transaction::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'balance' => Transaction::query()->where('user_id', $payment->user_id)->sum('amount') + $payment->amount
        ]);

        $user = User::findOrFail($payment->user_id);

        //TODO change condition with ali function
        $userUpdatedStatus = $user->update([
            "balance->{$payment->currency}" =>   Transaction::query()->where('user_id', $payment->user_id)->sum('amount')
        ]);

        if ($userUpdatedStatus) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        PaymentVerified::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_verified'))
            ->data(new PaymentResource($payment))
            ->status(200)
            ->send();
    }
}
