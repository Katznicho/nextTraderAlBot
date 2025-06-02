<?php

namespace App\Http\Controllers;

use App\Services\PaygatePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SignalController extends Controller
{
    protected $signals;

    public function __construct()
    {
        // Define all signals as a class property so we can access them in other methods
        $this->signals = collect([
            (object)[
                'id' => 1,
                'name' => 'AI Scalper Pro',
                'description' => 'High-frequency signal optimized for volatile markets.',
                'price' => 39.99,
                'features' => ['Scalping Strategy', '5-10 trades/day', 'US30, NASDAQ pairs']
            ],
            (object)[
                'id' => 2,
                'name' => 'Swing Trader AI',
                'description' => 'Perfect for medium-term traders with low risk tolerance.',
                'price' => 32.99,
                'features' => ['4H + Daily Chart Patterns', 'Risk-managed trades', 'BTC, ETH, Gold']
            ],
            (object)[
                'id' => 3,
                'name' => 'Forex Beast Mode',
                'description' => 'Aggressive FX signals with automated TP/SL levels.',
                'price' => 44.99,
                'features' => ['High Risk/Reward', 'Auto TP/SL', 'EUR/USD, GBP/JPY']
            ],
            (object)[
                'id' => 4,
                'name' => 'Gold Digger Signals',
                'description' => 'Daily XAU/USD signals with clear entry/exit zones.',
                'price' => 41.99,
                'features' => ['Daily Gold Trades', 'Support & Resistance Zones', 'Low Drawdown']
            ],
            (object)[
                'id' => 5,
                'name' => 'Crypto Momentum AI',
                'description' => 'AI-generated signals for trending crypto markets.',
                'price' => 37.99,
                'features' => ['Momentum-based Strategy', 'Top 10 Altcoins', 'Auto Entry Alerts']
            ],
            (object)[
                'id' => 6,
                'name' => 'London Breakout FX',
                'description' => 'Trades breakouts from the London session with tight SL.',
                'price' => 47.99,
                'features' => ['Forex Only', '5am–9am GMT Trades', 'EUR/USD, GBP/USD']
            ],
            (object)[
                'id' => 7,
                'name' => 'US30 Killer Bot Feed',
                'description' => 'Raw, sniper US30 entries with premium R:R setups.',
                'price' => 34.99,
                'features' => ['High Frequency', 'Scalping US30', 'Live Alerts']
            ],
            (object)[
                'id' => 8,
                'name' => 'News Impact Signals',
                'description' => 'Signals around major economic news events like NFP, CPI.',
                'price' => 32.49,
                'features' => ['Volatility Exploits', 'Auto SL Buffer', 'Pre/Post-News Alerts']
            ],
            (object)[
                'id' => 9,
                'name' => 'Swing Vault FX',
                'description' => 'Designed for traders who prefer fewer but stronger setups.',
                'price' => 49.99,
                'features' => ['2–4 Trades/Week', 'Daily/Weekly Charts', 'Forex Majors']
            ],
            (object)[
                'id' => 10,
                'name' => 'Crypto Reversal Sniper',
                'description' => 'Catch altcoin reversals early using sentiment + price data.',
                'price' => 36.99,
                'features' => ['Sentiment Analysis', 'Altcoins Only', 'Reversal Strategy']
            ],
            (object)[
                'id' => 11,
                'name' => 'Indices Power Swing',
                'description' => 'Signals for S&P 500, Dow Jones, and NASDAQ 100 with wide targets.',
                'price' => 33.99,
                'features' => ['Swing Trading Indices', '3-5 Days Hold', 'Risk Management']
            ],
            (object)[
                'id' => 12,
                'name' => 'Smart Grid Zones',
                'description' => 'Supports grid-style bot trading with optimized entry zones.',
                'price' => 45.99,
                'features' => ['Grid Strategy Zones', 'Bot Compatible', 'Low Maintenance']
            ],
        ]);
    }

    public function index()
    {
        $signals = $this->signals;
        return view('signals.index', compact('signals'));
    }

    public function subscribe(Request $request, $signal)
    {
        $signalObj = $this->signals->firstWhere('id', (int)$signal);

        // dd($signalObj);


        if (!$signalObj) {
            return redirect()->route('signals.index')->with('error', 'Signal not found.');
        }
        // Pull out the amount
        $amount = $signalObj->price;
        //    dd($amount);

        // You can store to DB, session, or just mock success
        // Here's a basic session example:
        // Session::flash('success', "You have successfully subscribed to {$signalObj->name}.");

        // return redirect()->route('signals.index');
        $payment = new PaygatePaymentService();

        //    dd($res);  
        //generate a random string of 10 characters
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);

        //generate a random string of 10 characters
        $paymentUrl = $payment->generatePaymentUrl(
            orderNumber: $randomString,
            amount: $amount,
            email: Auth::user()->email,
            provider: 'particle',
            currency: 'USD'
        );
        // dd($paymentUrl);

        return redirect()->away($paymentUrl);
        // Send the URL to the view or frontend
        //return view('payments.redirect', compact('paymentUrl'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
