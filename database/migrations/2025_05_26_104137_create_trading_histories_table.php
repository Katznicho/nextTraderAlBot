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
        Schema::create('trading_histories', function (Blueprint $table) {
            $table->id();
        
            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // Trade Details
            $table->string('exchange')->default('binance'); // or bybit, etc.
            $table->string('symbol'); // e.g., BTC/USDT
            $table->enum('side', ['buy', 'sell']);
            $table->decimal('quantity', 20, 8); // amount of crypto bought/sold
            $table->decimal('price', 20, 8); // price at which trade was executed
            $table->decimal('total', 20, 8); // total = quantity * price
        
            // Result Info
            $table->decimal('profit', 20, 8)->nullable(); // positive or negative
            $table->decimal('fees', 20, 8)->nullable(); // exchange fees
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            
            // Trade Metadata
            $table->string('order_id')->nullable(); // exchange order ID
            $table->timestamp('executed_at')->nullable(); // actual trade time
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_histories');
    }
};
