<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'user_id' => $this->user_id,
            'payment_id' => $this->payment_id,
            'currency' => $this->currency,
            'unique_id' => $this->unique_id,
            'created_at' => $this->created_at,
        ];
    }
}
