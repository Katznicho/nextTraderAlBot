<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;



    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'payment_reference',
        'amount',
        'status',
        'payment_method',
        'paid_at',
        'gateway_response',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
