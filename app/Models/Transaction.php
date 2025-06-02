<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'transaction_type',
        'account_id',
        'group_id',
        'fund_raisers_id',
        'currency',
        'transaction_purpose',
        'amount',
        'payment_method',
        'anonymous',
        'transaction_date',
        'transaction_reference',
        'description',
        'date',
        'status',
        'transaction_fee',
        'payment_provider',
        'network',
        'device_id',
        'group_activity_id',
        'phone_number',
        'loan_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function group()
    {
        return $this->belongsTo(GroupAccount::class, 'group_id');
    }

    public function fundraiser()
    {
        return $this->belongsTo(FundRaiser::class, 'fund_raisers_id');
    }

    public function account()
    {
        return $this->belongsTo(PersonalAccount::class, 'account_id');
    }

    public function groupActivity()
    {
        return $this->belongsTo(GroupActivity::class, 'group_activity_id');
    }
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    

    
}
