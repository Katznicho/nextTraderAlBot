<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Add this
        'platform',
        'account_id',
        'server',
        'login',
        'password',
        'fuel_balance',
        'last_fueled_at',
        'is_active',
        'connection_status',
        'last_connected_at',
        'current_strategy',
        'status_message',
    ];

    protected $casts = [
        'last_fueled_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
