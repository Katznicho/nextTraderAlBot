<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;
use Illuminate\Support\Arr; // Ad

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
    public $recentTrades;

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
        $this->topPairs = $this->generateRandomForexPairs();

        //recent trades
        $pairs = ['EUR/USD', 'GBP/USD', 'USD/JPY', 'USD/CHF', 'AUD/USD', 'USD/CAD'];

    // 🟢 Randomly generate recent trades
    $this->recentTrades = collect($pairs)->random(4)->map(function ($pair) {
        return [
            'pair' => $pair,
            'side' => Arr::random(['Buy', 'Sell']),
            'price' => number_format(mt_rand(10000, 200000) / 100000, 5),
            'time' => now()->subMinutes(rand(1, 30))->format('H:i:s'),
        ];
    })->toArray();

    // 🟢 Randomly generate open positions
    $this->openPositions = collect($pairs)->random(3)->map(function ($pair) {
        $entry = mt_rand(10000, 200000) / 100000;
        $current = $entry + ((rand(0, 1) ? 1 : -1) * mt_rand(10, 50) / 10000); // simulate movement
        $pips = round(($current - $entry) * 10000, 1);
        return [
            'pair' => $pair,
            'side' => Arr::random(['Buy', 'Sell']),
            'entry' => number_format($entry, 5),
            'current' => number_format($current, 5),
            'pnl' => ($pips >= 0 ? '+' : '') . $pips . ' pips',
        ];
    })->toArray();
        //recent trades

    
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

    public function generateRandomForexPairs()
{
    $pairs = ['EUR/USD', 'USD/JPY', 'GBP/USD', 'AUD/USD', 'USD/CAD', 'NZD/USD', 'USD/CHF'];
    $topPairs = [];

    foreach ($pairs as $pair) {
        $price = number_format(rand(90, 150) + rand(0, 9999) / 10000, 4);
        $change = round((rand(-300, 300) / 100), 2); // +/- 3.00%

        $topPairs[] = [
            'pair' => $pair,
            'price' => $price,
            'change' => ($change >= 0 ? '+' : '') . $change,
        ];
    }

    return $topPairs;
}

}
