<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;
use Illuminate\Support\Arr;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WithdrawalProcessingMail;
use App\Models\User;


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
    public $openPositions;

    public $withdrawalAmount;
    public $cryptoAddress;
    public $cryptoCurrency;

    // Add validation rules
    protected $rules = [
        'withdrawalAmount' => 'required|numeric|min:20',
        'cryptoAddress' => 'required|string|min:26|max:100',
        'cryptoCurrency' => 'required|in:BTC,ETH,USDT',
    ];

    public function mount()
    {
        $this->balance = Auth::user()->balance;
        $this->lastUpdate = now()->format('H:i:s');
        $this->profitLoss = Auth::user()->profit;
        $this->totalTrades = Auth::user()->total_trades;
        $this->chartId = 'tv_' . Str::random(10);
        $this->showFreezeWarning = $this->balance <= 0;
        $this->freezeCountdown = 24 * 60 * 60;

        // Check user subscription plan
        $this->userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        // Hardcoded top trading pairs with mock data
        $this->topPairs = $this->generateRandomForexPairs();

        // Recent trades
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

    public function submitWithdrawal()
    {
        try {
            $this->validate([
                'withdrawalAmount' => 'required|numeric|min:20|max:' . $this->balance,
                'cryptoAddress' => 'required|string',
                'cryptoCurrency' => 'required|in:BTC,ETH,USDT',
            ]);

            $user = Auth::user();
            $user_id = $user->id;

            $user = User::find($user_id);

            // Simulate conversion rate (replace with real API call in production)
            $conversionRates = [
                'BTC' => 0.000020,
                'ETH' => 0.00030,
                'USDT' => 1.0,
            ];

            $convertedAmount = $this->withdrawalAmount * $conversionRates[$this->cryptoCurrency];

            // Begin transaction
            DB::beginTransaction();

            // Store the withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount_usd' => $this->withdrawalAmount,
                'crypto_currency' => $this->cryptoCurrency,
                'crypto_address' => $this->cryptoAddress,
                'converted_amount' => $convertedAmount,
                'status' => 'Pending',
            ]);

            // Deduct user balance
             $user->decrement('balance', $this->withdrawalAmount);

            //decrement balance the user balance
            // $user->balance -= $this->withdrawalAmount;
            // $user->save();

            DB::commit();

            // Refresh balance in component
            $this->balance = $user->fresh()->balance;
            $this->showFreezeWarning = $this->balance <= 0;

            // Send email notification
            Mail::to($user->email)->send(new WithdrawalProcessingMail($withdrawal, $user));

            // Reset form inputs
            $this->reset(['withdrawalAmount', 'cryptoAddress', 'cryptoCurrency']);

            // Close modal
            // $this->dispatchBrowserEvent('close-modal', ['id' => 'withdrawal-modal']);

            session()->flash('success', 'Your withdrawal request is being processed.');
        } catch (\Exception $e) {
            DB::rollBack();
           dd($e->getMessage());
            // Optionally log the error
            Log::error('Withdrawal error: ' . $e->getMessage());

            session()->flash('error', 'An error occurred while processing your withdrawal. Please try again later.');
        }
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
