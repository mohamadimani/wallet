<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'priceunit' =>  $request->priceunit,
            'attach_file' =>  $request->attach_file,
            'payment_at' => $request->payment_at,
        ];

        $payment = payment::create($input);
        return response()->json($payment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        //
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

            $payment->updates($input);
            return response()->json($payment, 200);
        } catch (ModelNotFoundException $exception) {
            dd('ssssss');
            return response()->json('error', 400);
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
