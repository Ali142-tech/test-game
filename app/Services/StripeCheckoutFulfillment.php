<?php

namespace App\Services;

use App\Models\TicketOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeCheckoutFulfillment
{
    public function fulfillFromSession(object $session): bool
    {
        $orderId = $session->metadata->order_id ?? null;

        if (! $orderId) {
            Log::warning('Stripe checkout session missing order_id metadata', [
                'session_id' => $session->id ?? null,
            ]);

            return false;
        }

        if (($session->payment_status ?? null) !== 'paid') {
            return false;
        }

        return DB::transaction(function () use ($orderId, $session) {
            $order = TicketOrder::query()->lockForUpdate()->find($orderId);

            if (! $order) {
                Log::warning('Stripe checkout references unknown order', [
                    'order_id' => $orderId,
                    'session_id' => $session->id ?? null,
                ]);

                return false;
            }

            if ($order->isPaid()) {
                return true;
            }

            $order->update([
                'status' => TicketOrder::STATUS_PAID,
                'delivery_status' => TicketOrder::DELIVERY_PENDING,
                'payment_reference' => $session->payment_intent,
                'stripe_session_id' => $session->id,
            ]);

            return true;
        });
    }
}
