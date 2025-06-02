<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'features',
        'is_custom',   
    ];

    protected $casts = [
        'features' => 'array',
    ];

   
}
