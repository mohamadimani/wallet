<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'title' => $this->title,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_at' => $this->payment_at,
            'created_at' => $this->created_at,
            'unique_id' => $this->unique_id,
            'status' => $this->status,
            'user' => $this->user,
        ];
    }
}
