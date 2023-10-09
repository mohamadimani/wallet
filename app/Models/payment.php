<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatusEnum;
use Ramsey\Uuid\Type\Integer;

class payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'amount',
        'priceunit',
        'attach_file',
        'payment_at',
        'status',
        'rejected_at',
        'verified_at',
    ];


    protected $casts = [
        'status' => PaymentStatusEnum::class
    ];
}
