<?php

namespace App\Http\Controllers;

use App\Models\TradingHistory;
use App\Models\UserSubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if (!$userPlan) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You must have an active subscription to access this feature.');
        }
        $trades = TradingHistory::where('user_id', Auth::id())
            ->latest('executed_at')
            ->get();

        return view("trading-history.index", compact('trades'));
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
