<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_orders', function (Blueprint $table) {
            $table->string('refund_status', 20)->nullable()->after('payment_reference');
            $table->string('stripe_refund_id')->nullable()->after('refund_status');
            $table->timestamp('refunded_at')->nullable()->after('stripe_refund_id');
            $table->text('refund_failure_reason')->nullable()->after('refunded_at');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_orders', function (Blueprint $table) {
            $table->dropColumn([
                'refund_status',
                'stripe_refund_id',
                'refunded_at',
                'refund_failure_reason',
            ]);
        });
    }
};
