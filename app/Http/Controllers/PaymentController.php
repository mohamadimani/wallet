<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Events\RejectPaymentEvent;
use App\Events\StorePaymentEvent;
use App\Events\VerifyPaymentEvent;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use App\Helpers\Helper;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Jobs\RejectPaymentEmail;
use App\Mail\RejectedPayment;
use App\Mail\StorePayment;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = payment::all();
        return  $this->successResponse(new PaymentCollection($payments), __('payment.messages.payment_list_found_successfully'), 200);
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

        return  $this->successResponse(new PaymentResource($payment), __('payment.messages.payment_successfuly_created'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        return  $this->successResponse(new PaymentResource($payment), __('payment.messages.payment_successfuly_found'));
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
            return  $this->errorResponse(['error'], __('payment.errors.you_can_only_decline_pending_payments'), 400);
        }
        $input = [
            'status' => PaymentStatusEnum::Rejected
        ];
        $payment->update($input);

        RejectPaymentEvent::dispatch($payment);
        // RejectPaymentEmail::dispatch($payment, $message);

        return  $this->successResponse($payment, __('payment.messages.the_payment_was_successfully_rejected'));
    }

    public function verify(payment $payment)
    {

        // if ($payment->status->value != PaymentStatusEnum::Pending->value) {
        //     return  $this->errorResponse(['error'], __('payment.errors.you_can_only_verify_pending_payments'), 400);
        // }
        $input = [
            'status' => PaymentStatusEnum::Verified
        ];
        $payment->update($input);

        VerifyPaymentEvent::dispatch($payment);
        // RejectPaymentEmail::dispatch($payment, $message);

        return  $this->successResponse($payment, __('payment.messages.the_payment_was_successfully_verified'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        //
    }
}
