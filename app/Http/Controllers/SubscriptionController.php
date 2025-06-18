<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;
use App\Services\PaygatePaymentService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $plans = SubscriptionPlan::all();
        $userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        return view('subscriptions.index', [
            'plans' => $plans,
            'userPlan' => $userPlan,
            'needsSubscription' => !$userPlan
        ]);
    }
    public function subscribe(SubscriptionPlan $plan)
    {
        // For now, just redirect to a payment page or show subscription details
        return view('subscriptions.subscribe', [
            'plan' => $plan
        ]);
    }
    public function process(Request $request, SubscriptionPlan $plan)
{
    $validated = $request->validate([
        'payment_mode' => 'required|in:card,crypto',
    ]);

    if ($plan->is_custom) {
        return redirect()->route('contact.sales')->with('info', 'Please contact our sales team for this plan.');
    }

    // Create a new subscription record
    $subscription = UserSubscriptionPlan::create([
        'user_id' => auth()->id(),
        'subscription_plan_id' => $plan->id,
        'status' => 'pending',
        'start_date' => now(),
        'end_date' => now()->addMonth(), // Optional: handle billing_cycle logic here
        'billing_cycle' => $plan->billing_cycle,
        'payment_mode' => $validated['payment_mode'],
    ]);

    // CARD PAYMENT GATEWAY (e.g., Stripe, Flutterwave)
    if ($validated['payment_mode'] === 'card') {
        return $this->initiateCardPayment($plan, $subscription);
    }

    // CRYPTO PAYMENT GATEWAY (e.g., CoinGate, NowPayments)
    if ($validated['payment_mode'] === 'crypto') {
        return $this->initiateCryptoPayment($plan, $subscription);
    }

    return redirect()->route('subscriptions.index')->with('error', 'Invalid payment option.');
}

// protected function initiateCryptoPayment(SubscriptionPlan $plan, UserSubscriptionPlan $subscription)
// {
//     // Map your plans to their NowPayments invoice links
//     $cryptoLinks = [
//         'Basic' => 'https://nowpayments.io/payment/?iid=5863218956',
//         'Pro'   => 'https://nowpayments.io/payment/?iid=5919588694',
//     ];

//     $planName = $plan->name;

//     // If a match is found, redirect to the correct crypto invoice
//     if (isset($cryptoLinks[$planName])) {
//         return redirect()->away($cryptoLinks[$planName]);
//     }

//     // If no match found, return with an error
//     return redirect()->route('subscriptions.index')
//         ->with('error', 'Crypto payment link not found for this plan.');
// }

protected function initiateCryptoPayment(SubscriptionPlan $plan, UserSubscriptionPlan $subscription)
{
    // Create Payment Record
    $payment = Payments::create([
        'user_id' => auth()->id(),
        'subscription_plan_id' => $plan->id,
        'payment_reference' => 'crypto_' . uniqid(),
        'amount' => $plan->price,
        'status' => 'pending',
        'payment_method' => 'crypto',
        'paid_at' => null,
        'gateway_response' => null,
    ]);

    // Choose correct NOWPayments link
    $redirectUrl = match($plan->name) {
        'Basic' => 'https://nowpayments.io/payment/?iid=5359072345',
        'Pro' => 'https://nowpayments.io/payment/?iid=5919588694',
        default => route('subscriptions.index'),
    };

    return redirect()->away($redirectUrl);
}


protected function initiateCardPayment(SubscriptionPlan $plan, UserSubscriptionPlan $subscription)
{
    // Create Payment Record
    $payment = Payments::create([
        'user_id' => auth()->id(),
        'subscription_plan_id' => $plan->id,
        'payment_reference' => 'card_' . uniqid(),
        'amount' => $plan->price,
        'status' => 'pending',
        'payment_method' => 'card',
        'paid_at' => null,
        'gateway_response' => null,
    ]);

    $paygate = new PaygatePaymentService();

    $paymentUrl = $paygate->generatePaymentUrl(
        orderNumber: $payment->id,
        amount: $plan->price,
        email: auth()->user()->email,
        provider: 'particle',
        currency: 'USD'
    );

    return redirect()->away($paymentUrl);
}



// protected function initiateCardPayment(SubscriptionPlan $plan, UserSubscriptionPlan $subscription)
// {
//     $payment = new PaygatePaymentService();

//     $paymentUrl = $payment->generatePaymentUrl(
//         orderNumber: $subscription->id,
//         amount: $plan->price,
//         email: auth()->user()->email,
//         provider: 'particle',
//         currency: 'USD'
//     );

//     return redirect()->away($paymentUrl);
// }
}

//https://nowpayments.io/payment/?iid=5863218956
//https://nowpayments.io/payment/?iid=5919588694