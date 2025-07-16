<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;



    protected $fillable = [
        'user_id',  
        'amount_usd',
        'crypto_currency',
        'crypto_address',
        'converted_amount',
        'status',
    ];
    protected $casts = [
        'amount_usd' => 'decimal:2',
        'converted_amount' => 'decimal:8',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
