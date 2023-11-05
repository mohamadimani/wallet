<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_account',
        'to_account',
        'amount',
        'created_by',
        'currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'from_account', 'id');
    }
}
