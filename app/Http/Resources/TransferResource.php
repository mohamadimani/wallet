<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'from_account' => $this->user,
            'to_account' => $this->user,
            'created_by' => $this->created_by,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
        ];
    }
}
