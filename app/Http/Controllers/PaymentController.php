<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Events\RejectPaymentEvent;
use App\Events\StorePaymentEvent;
use App\Events\VerifyPaymentEvent;
use App\Exceptions\PaymentException;
use App\Facades\ApiResponse;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use App\Helpers\Helper;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Jobs\RejectPaymentEmail;
use App\Mail\RejectedPayment;
use App\Mail\StorePayment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = payment::all();
        $payments = payment::paginate($request->perpage ?? 10);

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
            'status' => PaymentStatusEnum::Rejected
        ];
        $payment->update($input);

        RejectPaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_rejected'))
            ->data($payment)
            ->status()
            ->send();
    }

    public function verify(payment $payment)
    {
        if ($payment->status->value != PaymentStatusEnum::Pending->value) {
            throw new BadRequestHttpException(__('payment.errors.you_can_only_verify_pending_payments'));
        }

        $input = [
            'status' => PaymentStatusEnum::Verified
        ];
        $payment->update($input);

        VerifyPaymentEvent::dispatch($payment);

        return ApiResponse::message(__('payment.messages.the_payment_was_successfully_verified'))
            ->data($payment)
            ->status(200)
            ->send();
    }
}
