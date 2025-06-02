<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;

class Dashboard extends Component
{
    public $balance;
    public $lastUpdate;
    public $profitLoss;
    public $totalTrades;
    public $chartId;
    public $topPairs;
    public $indicators;
    public $freezeCountdown;
    public $showFreezeWarning;
    public $userPlan;

    public function mount()
    {
        $this->balance = Auth::user()->balance;
        $this->lastUpdate = now()->format('H:i:s');
        $this->profitLoss = 0;
        $this->totalTrades = 0;
        $this->chartId = 'tv_' . Str::random(10);
        $this->showFreezeWarning = $this->balance <= 0;
        $this->freezeCountdown = 24 * 60 * 60;
    
        // Check user subscription plan
        $plans = SubscriptionPlan::all();
        $this->userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
    
        // Hardcoded top trading pairs with mock data
        $this->topPairs = [
            ['pair' => 'BTC/USDT', 'price' => '43250.00', 'change' => '+2.5'],
            ['pair' => 'ETH/USDT', 'price' => '2280.00', 'change' => '+1.8'],
            ['pair' => 'BNB/USDT', 'price' => '305.50', 'change' => '-0.5'],
            ['pair' => 'SOL/USDT', 'price' => '98.75', 'change' => '+4.2'],
        ];
    
        // Hardcoded trading indicators
        $this->indicators = [
            ['name' => 'RSI (14)', 'value' => '58', 'signal' => 'Neutral'],
            ['name' => 'MACD', 'value' => '0.0025', 'signal' => 'Buy'],
            ['name' => 'MA (200)', 'value' => '41200', 'signal' => 'Strong Buy'],
            ['name' => 'Bollinger Bands', 'value' => '42100-44300', 'signal' => 'Hold'],
        ];
    }

    protected $listeners = ['refreshChart' => 'refreshChartId'];

    public function refreshChartId()
    {
        $this->chartId = 'tv_' . Str::random(10);
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'userPlan' => $this->userPlan,
        ]);
    }

    public function getFormattedCountdownProperty()
    {
        $hours = floor($this->freezeCountdown / 3600);
        $minutes = floor(($this->freezeCountdown % 3600) / 60);
        $seconds = $this->freezeCountdown % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
