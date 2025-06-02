<?php

namespace App\Http\Controllers;

use App\Models\BotConfiguration;
use App\Models\UserSubscriptionPlan;
use Illuminate\Http\Request;

class BotConfigurationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('subscription');
    // }

    public function index(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())->first();

        if (!$botConfig) {
            return redirect()->route('bot.configure')
                ->with('info', 'Please configure your trading bot first.');
        }

        if (!$botConfig->is_active || $botConfig->connection_status !== 'connected') {
            return redirect()->route('bot.connect')
                ->with('warning', 'Your bot needs to be connected before trading.');
        }

        if ($botConfig->fuel_balance <= 0) {
            return redirect()->route('bot.fuel')
                ->with('warning', 'Your bot needs fuel to operate. Please add fuel balance.');
        }

        // If all checks pass, show the bot configuration dashboard
        return view('bot.dashboard', [
            'botConfig' => $botConfig
        ]);
    }

    // public function configure(Request $request)
    // {
    //     return view('bot.configure');
    // }

    public function configure(Request $request)
{
    $userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
        ->where('status', 'active')
        ->first();

    if (!$userPlan) {
        return redirect()->route('subscriptions.index')
            ->with('error', 'You must have an active subscription to access this feature.');
    }

    return view('bot.configure');
}

    public function connect(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())
            ->firstOrFail();

        return view('bot.connect', [
            'botConfig' => $botConfig
        ]);
    }

    public function fuel(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())
            ->firstOrFail();

        return view('bot.fuel', [
            'botConfig' => $botConfig
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|in:mt4,mt5',
            'account_id' => 'required|string',
            'server' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        $botConfig = BotConfiguration::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'platform' => $validated['platform'],
                'account_id' => $validated['account_id'],
                'server' => $validated['server'],
                'login' => $validated['login'],
                'password' => $validated['password'],
                'connection_status' => 'disconnected',
                'is_active' => false,
                'fuel_balance' => 0
            ]
        );

        return redirect()->route('bot.connect')
            ->with('success', 'Bot configuration saved successfully!');
    }

    public function connectStore(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())->firstOrFail();
        
        // Here you would implement the actual connection logic
        $botConfig->update([
            'connection_status' => 'connected',
            'last_connected_at' => now()
        ]);

        return redirect()->route('bot.fuel')
            ->with('success', 'Bot connected successfully!');
    }

    public function fuelStore(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);

        $botConfig = BotConfiguration::where('user_id', auth()->id())->firstOrFail();
        
        $botConfig->update([
            'fuel_balance' => $botConfig->fuel_balance + $validated['amount'],
            'last_fueled_at' => now()
        ]);

        return redirect()->route('bot.index')
            ->with('success', "Successfully added $$validated[amount] fuel to your bot!");
    }

    public function toggle(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())->firstOrFail();
        
        $botConfig->update([
            'is_active' => !$botConfig->is_active
        ]);

        $status = $botConfig->is_active ? 'started' : 'stopped';
        return redirect()->route('bot.index')
            ->with('success', "Bot has been $status successfully!");
    }
}
