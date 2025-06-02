<?php

namespace App\Http\Controllers;

use App\Services\PaygatePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddOnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public  $addons;
     public function __construct()
     {
         $this->addons =  collect([
            (object)[
                'id' => 1,
                'name' => 'Advanced Risk Manager',
                'description' => 'Add-on for dynamic lot sizing, max daily loss limits, and advanced risk controls.',
                'price' => 34.99,
                'features' => ['Auto Lot Adjustment', 'Max Daily Drawdown', 'Per Trade SL Cap']
            ],
            (object)[
                'id' => 2,
                'name' => 'Smart News Filter',
                'description' => 'Pauses the bot during high-impact news events to avoid volatility.',
                'price' => 49.99,
                'features' => ['News Sync with Forex Factory', 'NFP/Interest Rate Protection', 'Pause & Resume Bot']
            ],
            (object)[
                'id' => 3,
                'name' => '24/7 VPS Hosting',
                'description' => 'Run your bot on a secure, low-latency cloud server. No need to keep your device on.',
                'price' => 39.99,
                'features' => ['Cloud Hosting', '99.9% Uptime', 'Auto Start on Crash']
            ],
            (object)[
                'id' => 4,
                'name' => 'Backtest Analyzer',
                'description' => 'Run backtests with visual results and strategy optimization.',
                'price' => 42.99,
                'features' => ['Multi-Year Backtest', 'Custom Date Range', 'Win/Loss Heatmap']
            ],
            (object)[
                'id' => 5,
                'name' => 'Telegram Alerts Integration',
                'description' => 'Receive real-time bot notifications, trades, and signals in your Telegram.',
                'price' => 36.99,
                'features' => ['Entry/Exit Alerts', 'Profit Notifications', 'Telegram Bot Support']
            ],
            (object)[
                'id' => 6,
                'name' => 'Manual Override Panel',
                'description' => 'Pause the bot and enter trades manually using your judgment.',
                'price' => 37.99,
                'features' => ['Bot On/Off Toggle', 'Manual Order Entry', 'Live Bot Logs']
            ],
            (object)[
                'id' => 7,
                'name' => 'Auto Fund Manager',
                'description' => 'Automatically withdraw profits or re-invest them weekly.',
                'price' => 40.99,
                'features' => ['Profit Split Scheduling', 'Auto Reinvestment', 'Bank/Wallet Withdrawals']
            ],
            (object)[
                'id' => 8,
                'name' => 'Custom Trading Sessions',
                'description' => 'Set specific times for your bot to be active (e.g., London/NY only).',
                'price' => 38.49,
                'features' => ['Custom Time Windows', 'Timezone Support', 'Silent Mode']
            ],
            (object)[
                'id' => 9,
                'name' => 'Bot Theme Pack',
                'description' => 'Customize the UI of your bot dashboard with pro themes.',
                'price' => 34.99,
                'features' => ['Dark/Light Themes', 'Color Presets', 'Custom Branding']
            ],
            (object)[
                'id' => 10,
                'name' => 'Trading Journal Pro',
                'description' => 'Auto-record and analyze your trades for review and growth.',
                'price' => 41.99,
                'features' => ['Auto Logging', 'Daily/Weekly Reports', 'Growth Charts']
            ],
        ]);
     }
    public function index()
    {
        //
        $addons  = $this->addons;
        

        return view('addons.index', compact('addons')); // Assuming you have a view for this lis
    }

    public function activate(Request $request, $addonId)
    {
        // $addon = Addon::findOrFail($addonId);
        $selectedAddon = $this->addons->firstWhere('id', $addonId);
        if (!$selectedAddon) {
            return back()->with('error', 'Add-on not found!');
        }
        // Check if the add-on is already activated
        // dd("I am here");
        $amount = $selectedAddon->price;

        // dd($amount);
        $payment = new PaygatePaymentService();

        //    dd($res);  
        //generate a random string of 10 characters
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);

        //generate a random string of 10 characters
        $paymentUrl = $payment->generatePaymentUrl(
            orderNumber: $randomString,
            amount: $amount,
            email: Auth::user()->email,
            provider: 'guardarian',
            currency: 'USD'
        );
        // dd($paymentUrl);

        return redirect()->away($paymentUrl);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
