<?php

use App\Http\Controllers\AddOnsController;
use App\Http\Controllers\BotConfigurationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SignalController;

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Psy\Command\HistoryCommand;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');


Route::get("makePayment",[PaymentController::class,"makePayment"])->name("makePayment");    

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    // Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::impersonate();
    // Route::middleware(['auth'])->group(function () {
    //     Route::get('/impersonate/{id}', function ($id) {
    //         $user = \App\Models\User::findOrFail($id);
    //         auth()->user()->impersonate($user);
    //         return redirect('/dashboard');
    //     })->name('impersonate');
    
    //     Route::get('/leave-impersonation', function () {
    //         auth()->user()->leaveImpersonation();
    //         return redirect('/users');
    //     })->name('impersonate.leave');
    // });

    // Robot
    Route::resource('payments', PaymentController::class);
    Route::resource("history", HistoryController::class);
    Route::resource("charts", ChartController::class);
    Route::resource("support", SupportController::class);
    Route::resource("bot-configuration", BotConfigurationController::class);
    Route::resource("reports", ReportController::class);
    Route::resource("subscriptions", SubscriptionController::class);
    Route::resource("signals", SignalController::class);
    Route::resource("addons",AddOnsController::class);
    Route::resource("trades", TradeController::class);
    Route::resource("users", UserController::class);

    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


    Route::get('/subscriptions/{plan}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::post('/subscriptions/{plan}/process', [SubscriptionController::class, 'process'])->name('subscriptions.process');
    Route::prefix('bot')->group(function () {
        Route::get('/', [BotConfigurationController::class, 'index'])->name('bot.index');
        Route::get('/configure', [BotConfigurationController::class, 'configure'])->name('bot.configure');
        Route::post('/store', [BotConfigurationController::class, 'store'])->name('bot.store');
        Route::get('/connect', [BotConfigurationController::class, 'connect'])->name('bot.connect');
        Route::post('/connect', [BotConfigurationController::class, 'connectStore'])->name('bot.connect.store');
        Route::get('/fuel', [BotConfigurationController::class, 'fuel'])->name('bot.fuel');
        Route::post('/fuel', [BotConfigurationController::class, 'fuelStore'])->name('bot.fuel.store');
        Route::post('/toggle', [BotConfigurationController::class, 'toggle'])->name('bot.toggle');
    });
    Route::post('/signals/subscribe/{signal}', [SignalController::class, 'subscribe'])->name('signals.subscribe');
    Route::post('/addons/{addon}/activate', [AddOnsController::class, 'activate'])->name('addons.activate');

    //Robot

    Route::get('/test-mail-view', function () {
        return view('mail.bot'); // ✅ Will confirm if Laravel can resolve this path
    });


    




});
