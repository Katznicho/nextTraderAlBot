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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Pro, Enterprise
            $table->decimal('price', 10, 2)->nullable(); // Null for custom pricing
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->json('features'); // Store plan features (optional)
            $table->boolean('is_custom')->default(false); // true for Enterprise
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcription_plans');
    }
};
