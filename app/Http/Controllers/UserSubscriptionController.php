<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscriptionPlan;

class UserSubscriptionController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_id' => 'required|exists:subscription_plans,id',
        ]);



        // Create the user subscription
        UserSubscriptionPlan::create([
            'user_id' => $validated['user_id'],
            'subscription_plan_id' => $validated['subscription_id'],
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'status' => 'active',
            // 'payment_reference' => '1234567890',
            // Add other fields as needed
        ]);

        return redirect()->back()->with('success', 'User subscription created!');
    }
}
