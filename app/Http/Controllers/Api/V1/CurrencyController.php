<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyCollection;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CurrencyController extends Controller
{
    // TODO validation for all and resource
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currencies = Currency::paginate($request->perpage ?? 10);

        return ApiResponse::message(__('currency.messages.currency_list_found_successfully'))
            ->data(new CurrencyCollection($currencies))
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
    public function store(StoreCurrencyRequest $request)
    {
        //TODO iso_code and add key
        $currency = Currency::create([
            'name' => $request->name,
            'iso_code' => $request->code,
            'symbol' => $request->symbol,
        ]);

        return ApiResponse::message(__('currency.messages.currency_successfuly_created'))
            ->data(new CurrencyResource($currency))
            ->status(201)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return ApiResponse::message(__('currency.messages.currency_successfuly_found'))
            ->data(new CurrencyResource($currency))
            ->status(200)
            ->send();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        //
    }

    public function inActive(Currency $currency)
    {
        if (!$currency->is_active) {
            throw new BadRequestHttpException(__('currency.errors.you_can_only_decline_active_currencies'));
        }
        $currency->update([
            'is_active' => false
        ]);

        return ApiResponse::message(__('currency.messages.currency_successfuly_inactivated'))
            ->data(new CurrencyResource($currency))
            ->status(200)
            ->send();
    }

    public function active(Currency $currency)
    {
        if ($currency->is_active) {
            throw new BadRequestHttpException(__('currency.errors.you_can_only_verify_inactive_currencies'));
        }
        $currency->update([
            'is_active' => true
        ]);

        return ApiResponse::message(__('currency.messages.currency_successfuly_activated'))
            ->data(new CurrencyResource($currency))
            ->status(200)
            ->send();
    }
}
