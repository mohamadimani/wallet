<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TransferStored;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Http\Resources\TransferResource;
use App\Models\Transfer;

class TransferController extends Controller
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
    public function store(StoreTransferRequest $request)
    {
        $transfer = Transfer::create([
            'from_account' => $request->from_account,
            'to_account' => $request->to_account,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'created_by' => $request->created_by,
        ]);

        TransferStored::dispatch($transfer);

        return ApiResponse::message(__('transfer.messages.transfer_successfuly_created'))
            ->data(new TransferResource($transfer))
            ->status(201)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
