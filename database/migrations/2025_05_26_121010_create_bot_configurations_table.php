<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bot_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // Bot Connection Details
            $table->string('platform')->default('mt5'); // mt5, mt4, binance, etc.
            $table->string('account_id')->nullable(); // Broker/Trading account ID
            $table->string('server')->nullable();
            $table->string('login')->nullable(); // Encrypted login
            $table->string('password')->nullable(); // Encrypted password
        
            // Bot Fuel / Credits
            $table->decimal('fuel_balance', 10, 2)->default(0.00);
            $table->timestamp('last_fueled_at')->nullable();
        
            // Bot Activation and Status
            $table->boolean('is_active')->default(false); // Bot on/off by user
            $table->enum('connection_status', ['connected', 'disconnected', 'error'])->default('disconnected');
            $table->timestamp('last_connected_at')->nullable();
            
            // Optional: Current Bot Run Info
            $table->string('current_strategy')->nullable(); // optional
            $table->string('status_message')->nullable(); // show errors or info
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_configurations');
    }
};
