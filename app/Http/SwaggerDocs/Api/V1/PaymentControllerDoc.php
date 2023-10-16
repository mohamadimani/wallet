<?php

namespace App\Http\SwaggerDocs\Api\V1;

use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\payment;
use Illuminate\Http\Request;

class PaymentControllerDoc
{

    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     operationId="PaymentIndex",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment List",
     *
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=201, description="Successful operation"),
     *      @OA\Response(response=202, description="Successful operation"),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */

    public function index(Request $request)
    {
    }

    public function create()
    {
    }

    public function store(StorepaymentRequest $request)
    {
    }

    public function show(payment $payment)
    {
    }

    public function edit(payment $payment)
    {
    }

    public function update(UpdatepaymentRequest $request, payment $payment)
    {
    }

    public function reject(payment $payment)
    {
    }

    public function verify(payment $payment)
    {
    }

    public function destroy(payment $payment)
    {
    }
}
