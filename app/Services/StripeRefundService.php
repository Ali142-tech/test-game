<?php

namespace App\Services;

use App\Models\TicketOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Refund;
use Stripe\Stripe;

class StripeRefundService
{
    public const REFUND_PENDING = 'pending';

    public const REFUND_SUCCEEDED = 'succeeded';

    public const REFUND_FAILED = 'failed';

    /**
     * Refund a paid order and mark it rejected. Idempotent if already refunded.
     *
     * @throws \RuntimeException
     */
    public function refundRejectedOrder(TicketOrder $order, string $deliveryNote): TicketOrder
    {
        return DB::transaction(function () use ($order, $deliveryNote) {
            $order = TicketOrder::query()->lockForUpdate()->findOrFail($order->id);

            if ($order->isRefunded()) {
                if ($order->delivery_status !== TicketOrder::DELIVERY_REJECTED) {
                    $order->update([
                        'delivery_status' => TicketOrder::DELIVERY_REJECTED,
                        'delivery_note' => $deliveryNote,
                    ]);
                }

                return $order->fresh();
            }

            if (! $order->isPaid()) {
                throw new \RuntimeException('Only paid orders can be refunded.');
            }

            if ($this->isDemoPayment($order)) {
                $order->update([
                    'status' => TicketOrder::STATUS_REFUNDED,
                    'delivery_status' => TicketOrder::DELIVERY_REJECTED,
                    'delivery_note' => $deliveryNote,
                    'refund_status' => self::REFUND_SUCCEEDED,
                    'refunded_at' => now(),
                ]);

                return $order->fresh();
            }

            if (! $order->payment_reference) {
                throw new \RuntimeException('This order has no Stripe payment reference and cannot be refunded.');
            }

            $stripeSecret = config('services.stripe.secret');

            if (! $stripeSecret) {
                throw new \RuntimeException('Stripe is not configured. Cannot process refund.');
            }

            Stripe::setApiKey($stripeSecret);

            try {
                $refund = Refund::create([
                    'payment_intent' => $order->payment_reference,
                    'metadata' => [
                        'order_id' => (string) $order->id,
                    ],
                    'reason' => 'requested_by_customer',
                ]);
            } catch (ApiErrorException $exception) {
                Log::error('Stripe refund failed', [
                    'order_id' => $order->id,
                    'payment_intent' => $order->payment_reference,
                    'message' => $exception->getMessage(),
                ]);

                throw new \RuntimeException('Stripe refund failed: '.$exception->getMessage());
            }

            $refundStatus = $refund->status === self::REFUND_SUCCEEDED
                ? self::REFUND_SUCCEEDED
                : self::REFUND_PENDING;

            $order->update([
                'status' => TicketOrder::STATUS_REFUNDED,
                'delivery_status' => TicketOrder::DELIVERY_REJECTED,
                'delivery_note' => $deliveryNote,
                'refund_status' => $refundStatus,
                'stripe_refund_id' => $refund->id,
                'refunded_at' => now(),
                'refund_failure_reason' => null,
            ]);

            return $order->fresh();
        });
    }

    public function syncFromRefund(object $refund): void
    {
        $orderId = $refund->metadata->order_id ?? null;
        $refundId = $refund->id ?? null;

        $order = null;

        if ($orderId) {
            $order = TicketOrder::query()->find($orderId);
        }

        if (! $order && $refundId) {
            $order = TicketOrder::query()->where('stripe_refund_id', $refundId)->first();
        }

        if (! $order) {
            Log::warning('Stripe refund webhook could not match order', [
                'refund_id' => $refundId,
                'order_id' => $orderId,
            ]);

            return;
        }

        $status = $refund->status ?? null;

        if ($status === self::REFUND_SUCCEEDED) {
            $order->update([
                'status' => TicketOrder::STATUS_REFUNDED,
                'refund_status' => self::REFUND_SUCCEEDED,
                'stripe_refund_id' => $refundId ?? $order->stripe_refund_id,
                'refunded_at' => $order->refunded_at ?? now(),
                'refund_failure_reason' => null,
            ]);

            return;
        }

        if ($status === 'failed' || $status === 'canceled') {
            $order->update([
                'refund_status' => self::REFUND_FAILED,
                'refund_failure_reason' => $refund->failure_reason ?? 'Refund '.$status,
            ]);
        }
    }

    private function isDemoPayment(TicketOrder $order): bool
    {
        return $order->payment_reference !== null
            && str_starts_with($order->payment_reference, 'demo-');
    }
}
