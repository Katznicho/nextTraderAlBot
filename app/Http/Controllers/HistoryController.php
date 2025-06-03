<?php

namespace App\Http\Controllers;

use App\Models\TradingHistory;
use App\Models\UserSubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function index(Request $request)
    // {
    //     $userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
    //         ->where('status', 'active')
    //         ->first();

    //     if (!$userPlan) {
    //         return redirect()->route('subscriptions.index')
    //             ->with('error', 'You must have an active subscription to access this feature.');
    //     }
    //     $trades = TradingHistory::where('user_id', Auth::id())
    //         ->latest('executed_at')
    //         ->get();

    //     return view("trading-history.index", compact('trades'));
    // }


    public function index(Request $request)
    {
        $userPlan = UserSubscriptionPlan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
    
        if (!$userPlan) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You must have an active subscription to access this feature.');
        }
    
        $user = Auth::user();
        $isAdmin = $user->user_type === 'Admin';
        // dd($isAdmin);
    
        if ($isAdmin) {
            // Delete existing trading history for this admin
            TradingHistory::where('user_id', $user->id)->delete();
    
            // Symbols and sides to randomly choose from
            $symbols = ['EUR/USD', 'BTC/USD', 'ETH/USD', 'XAU/USD', 'GBP/USD'];
            $sides = ['buy', 'sell'];
    
            // Generate 100 dummy trades
            for ($i = 0; $i < 100; $i++) {
                $symbol = $symbols[array_rand($symbols)];
                $side = $sides[array_rand($sides)];
                $quantity = rand(1, 10);
                $price = rand(100, 50000) / 100;
                $total = $quantity * $price;
                $profit = rand(-1000, 1000) / 10;
                $fees = rand(10, 300) / 100;
                $lotSize = rand(1, 10) / 10;
                $executedAt = now()->subDays(rand(0, 30))->addHours(rand(0, 23));
    
                TradingHistory::create([
                    'user_id' => $user->id,
                    'exchange' => 'Binance',
                    'symbol' => $symbol,
                    'side' => $side,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                    'profit' => $profit,
                    'fees' => $fees,
                    'status' => 'completed',
                    'order_id' => 'ORDER-' . strtoupper(Str::random(10)),
                    'executed_at' => $executedAt,
                    'lot_size' => $lotSize,
                ]);
            }
        }
    
        // Fetch the trades (dummy for admin, real for others)
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




