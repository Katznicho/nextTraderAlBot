<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Services\PaygatePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //finchpay
    //particle, guardarian ,kado
    public function makePayment(Request $request)
    {
        try {
            // dd("I am here");
            $payment = new PaygatePaymentService();

            $paymentUrl = $payment->generatePaymentUrl(
                orderNumber: 1234567892,
                amount: 50,
                email: 'katznicho@gmail.com',
                provider: 'particle',
                currency: 'USD'
            );

            return redirect()->away($paymentUrl);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }


    public function index()
    {
        $payments = Payments::with('subscriptionPlan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view("payments.index", compact('payments'));
    }

    public function completePayment(Request $request)
    {
        try {
            //code...
            Log::info($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }
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
