<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Type\Integer;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'amount',
        'currency',
        'attach_file',
        'payment_at',
        'status',
        'rejected_at',
        'verified_at',
        'unique_id',
    ];


    protected $casts = [
        'status' => PaymentStatusEnum::class
    ];

    public function getRouteKeyName()
    {
        return 'unique_id';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
