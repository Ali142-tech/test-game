<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('world_cup_match_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->unsignedInteger('amount')->comment('Amount in USD cents');
            $table->string('status')->default('pending');
            $table->string('stripe_session_id')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_orders');
    }
};
