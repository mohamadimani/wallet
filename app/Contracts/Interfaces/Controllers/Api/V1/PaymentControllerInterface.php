<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

interface PaymentControllerInterface
{

    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     operationId="PaymentIndex",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment List",
     *
     *     security={{"bearerAuth":{}}},
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
    public function index(Request $request);


    /**
     * @OA\Post(
     *     path="/api/v1/payments",
     *     operationId="PaymentStore",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Store",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(mediaType="application/json",
     *         @OA\Schema(type="object", required={"title", "user_id", "amount", "currency", "payment_at"},
     *         @OA\Property(property="title", type="text"),
     *         @OA\Property(property="user_id", type="int"),
     *         @OA\Property(property="amount", type="text"),
     *         @OA\Property(property="currency", type="text"),
     *         @OA\Property(property="attach_file", type="text"),
     *         @OA\Property(property="payment_at", type="text"),
     *     ),),),
     *
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=202, description="Successful operation"),
     *     @OA\Response(response=204, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function store(StorePaymentRequest $request);


    /**
     * @OA\Get(
     *     path="/api/v1/payments/{unique_id}",
     *     operationId="PaymentShow",
     *     tags={"PAYMENT"},
     *
     *     summary="GET Payment By UniqueId",
     *
     *     @OA\Parameter(
     *         name="unique_id",
     *         in="path",
     *         description="payment unique id",
     *         required=true,
     *         example="1234567890qwer",
     *         @OA\Schema(type="string")
     *      ),
     *
     *     security={{"bearerAuth":{}}},
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
    public function show(Payment $payment);

    /**
     * @OA\Patch(
     *     path="/api/v1/payments/{unique_id}/reject",
     *     operationId="PaymentReject",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Reject",
     *
     *     @OA\Parameter(
     *         name="unique_id",
     *         in="path",
     *         description="payment unique id",
     *         required=true,
     *         example="1234567890qwer",
     *         @OA\Schema(type="string")
     *      ),
     *
     *     security={{"bearerAuth":{}}},
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
    public function reject(Payment $payment);


    /**
     * @OA\Patch(
     *     path="/api/v1/payments/{unique_id}/verify",
     *     operationId="PaymentVerify",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Verify",
     *
     *     @OA\Parameter(
     *         name="unique_id",
     *         in="path",
     *         description="payment unique id",
     *         required=true,
     *         example="1234567890qwer",
     *         @OA\Schema(type="string")
     *      ),
     *
     *     security={{"bearerAuth":{}}},
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
    public function verify(Payment $payment);
}
