<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\StoreCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

interface CurrencyControllerInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     operationId="getListCurrency",
     *     tags={"Currency"},
     *     summary="summary",
     *     description="get list of Currency",
     *
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200,description="Successful operation"),
     *     @OA\Response(response=201,description="Successful operation"),
     *     @OA\Response(response=202,description="Successful operation"),
     *     @OA\Response(response=204,description="Successful operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=401,description="Unauthenticated"),
     *     @OA\Response(response=403,description="Forbidden"),
     *     @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function index();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/currencies/{id}",
     *     operationId="showCurrency",
     *     tags={"Currency"},
     *     summary="payment",
     *     description="get currency info",
     *      @OA\Parameter(
     *          name="id",
     *          description="currency id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=201,description="Successful operation"),
     *      @OA\Response(response=202,description="Successful operation"),
     *      @OA\Response(response=204,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Unauthenticated"),
     *      @OA\Response(response=403,description="Forbidden"),
     *      @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function show(Currency $currency);

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/v1/currencies",
     *     operationId="storeCurrency",
     *     tags={"Currency"},
     *     summary="currency",
     *     description="store currency",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"name","key"},
     *                  @OA\Property(property="name", type="text"),
     *                  @OA\Property(property="key", type="text"),
     *                  @OA\Property(property="symbol", type="text"),
     *                  @OA\Property(property="iso_code", type="text"),
     *                  @OA\Property(property="is_active", type="boolean"),
     *            ),
     *        ),
     *    ),
     *
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=201,description="Successful operation"),
     *      @OA\Response(response=202,description="Successful operation"),
     *      @OA\Response(response=204,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Unauthenticated"),
     *      @OA\Response(response=403,description="Forbidden"),
     *      @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function store(StoreCurrencyRequest $request);

    public function update(Request $request, Currency $currency);

    public function destroy(Currency $currency);

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Patch(
     *     path="/api/v1/currencies/{id}/active",
     *     operationId="activeCurrency",
     *     tags={"Currency"},
     *     summary="currency",
     *     description="active currency",
     *      @OA\Parameter(
     *          name="id",
     *          description="currency id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=201,description="Successful operation"),
     *      @OA\Response(response=202,description="Successful operation"),
     *      @OA\Response(response=204,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Unauthenticated"),
     *      @OA\Response(response=403,description="Forbidden"),
     *      @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function active(Currency $currency);

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Patch(
     *     path="/api/v1/currencies/{id}/deactive",
     *     operationId="deactiveCurrency",
     *     tags={"Currency"},
     *     summary="currency",
     *     description="deactive currency",
     *      @OA\Parameter(
     *          name="id",
     *          description="currency id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=201,description="Successful operation"),
     *      @OA\Response(response=202,description="Successful operation"),
     *      @OA\Response(response=204,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Unauthenticated"),
     *      @OA\Response(response=403,description="Forbidden"),
     *      @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function deactive(Currency $currency);
}
