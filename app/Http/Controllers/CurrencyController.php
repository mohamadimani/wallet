<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currencies = Currency::all();
        $currencies = Currency::paginate($request->perpage ?? 10);

        return ApiResponse::message(__('currency.messages.currency_list_found_successfully'))
            ->data($currencies)
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
        $input = [
            'name' => $request->name,
            'code' => $request->code,
            'symbol' => $request->symbol,
        ];
        $currency = Currency::create($input);
        // StoreCurrencyEvent::dispatch($currency);

        return ApiResponse::message(__('currency.messages.currency_successfuly_created'))
            ->data($currency)
            ->status(201)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return ApiResponse::message(__('currency.messages.currency_successfuly_found'))
            ->data($currency)
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
        $input = [
            'is_active' => false
        ];
        $currency->update($input);
        // RejectCurrencyEvent::dispatch($currency);

        return ApiResponse::message(__('currency.messages.currency_successfuly_inactivated'))
            ->data($currency)
            ->status(200)
            ->send();
    }

    public function active(Currency $currency)
    {
        if ($currency->is_active) {
            throw new BadRequestHttpException(__('currency.errors.you_can_only_verify_inactive_currencies'));
        }
        $input = [
            'is_active' => true
        ];
        $currency->update($input);
        // VerifyCurrencyEvent::dispatch($currency);

        return ApiResponse::message(__('currency.messages.currency_successfuly_activated'))
            ->data($currency)
            ->status(200)
            ->send();
    }
}
