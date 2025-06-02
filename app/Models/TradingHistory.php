<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingHistory extends Model
{
    use HasFactory;



    protected $fillable = [
        'user_id',
        'exchange',
        'symbol',
        'side',
        'quantity',
        'price',
        'total',
        'profit',
        'fees',
        'status',
        'order_id',
        'executed_at',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
