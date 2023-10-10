<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use App\Helpers\Helper;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = payment::all();
        return  $this->successResponse(new PaymentCollection($payments));
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
        return  $this->successResponse(new PaymentResource($payment));
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        return  $this->successResponse(new PaymentResource($payment));
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
    public function reject(UpdatepaymentRequest $request, payment $payment)
    {
        try {
            if ($payment->status->value != PaymentStatusEnum::Pending->value) {
                return response()->json('Cant set Rejected for status', 400);
            }
            $input = [
                'status' => PaymentStatusEnum::Rejected
            ];
            $payment->update($input);
            return  $this->successResponse($payment);
        } catch (ModelNotFoundException $exception) {
            return  $this->errorResponse(['error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        //
    }
}
