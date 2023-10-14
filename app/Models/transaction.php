<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactios extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'balance',
        'amount',
        'currency',
        'unique_id'
    ];
}
