<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PaymentStatusEnum;
use App\Events\IndexPaymentEvent;
use App\Events\RejectPaymentEvent;
use App\Events\ShowPaymentEvent;
use App\Events\StorePaymentEvent;
use App\Events\VerifyPaymentEvent;
use App\Facades\ApiResponse;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = payment::all();
        $payments = payment::paginate($request->perpage ?? 10);

        IndexPaymentEvent::dispatch($payments);

        return ApiResponse::message(__('payment.messages.payment_list_found_successfully'))
            ->data($payments)
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
    public function store(StorepaymentRequest $request)
    {
        $lastSamePayment = payment::where([['user_id', $request->user_id], ['amount', $request->amount], ['created_at', '>', Carbon::now()->subMinutes(5)]])->first();
        if ($lastSamePayment) {
            throw new BadRequestHttpException(__('payment.errors.you_can_create_same_paymant_after_5_minutes'));
        }
        $input = [
            'title' => $request->title,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'currency' =>  $request->currency,
            'attach_file' =>  $request->attach_file,
            'payment_at' => $request->payment_at,
            'unique_id' => Helper::uniqStr(),
        ];
        $payment = payment::create($input);

        StorePaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.payment_successfuly_created'))
            ->data($payment)
            ->status(201)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        ShowPaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.payment_successfuly_found'))
            ->data($payment)
            ->status(200)
            ->send();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequest $request, payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function reject(payment $payment)
    {

        if ($payment->status->value != PaymentStatusEnum::Pending->value) {
            throw new BadRequestHttpException(__('payment.errors.you_can_only_decline_pending_payments'));
        }

        $input = [
            'status' => PaymentStatusEnum::Rejected,
            'rejected_at' => time()
        ];
        $payment->update($input);

        RejectPaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_rejected'))
            ->data($payment)
            ->status(200)
            ->send();
    }

    public function verify(payment $payment)
    {
        if ($payment->status->value != PaymentStatusEnum::Pending->value) {
            throw new BadRequestHttpException(__('payment.errors.you_can_only_verify_pending_payments'));
        }

        DB::beginTransaction();

        $payment->lockForUpdate();
        $input = [
            'status' => PaymentStatusEnum::Verified,
            'verified_at' => time()
        ];
        $payment->update($input);

        $Transaction = Transaction::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'unique_id' => $payment->unique_id,
            'balance' => Transaction::query()->where('user_id', $payment->user_id)->sum('amount') + $payment->amount
        ]);

        $user = User::findOrFail($payment->user_id);
        $user->lockForUpdate();
        $user->update([
            'balance' => json_encode([$payment->currency => Transaction::query()->where('user_id', $payment->user_id)->sum('amount')])
        ]);

        if (!$user) {
            DB::rollBack();
        }
        DB::commit();

        VerifyPaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_verified'))
            ->data($payment)
            ->status(200)
            ->send();
    }
}
