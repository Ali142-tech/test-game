<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketOrder extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_REFUNDED = 'refunded';

    public const DELIVERY_PENDING = 'pending';

    public const DELIVERY_DELIVERED = 'delivered';

    public const DELIVERY_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'world_cup_match_id',
        'quantity',
        'amount',
        'status',
        'delivery_status',
        'delivery_note',
        'stripe_session_id',
        'payment_reference',
        'refund_status',
        'stripe_refund_id',
        'refunded_at',
        'refund_failure_reason',
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function worldCupMatch(): BelongsTo
    {
        return $this->belongsTo(WorldCupMatch::class);
    }

    public function formattedAmount(): string
    {
        return '$'.number_format($this->amount / 100, 0);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    public function isRefundPending(): bool
    {
        return $this->refund_status === 'pending';
    }

    public function deliveryStatusLabel(): string
    {
        return match ($this->delivery_status) {
            self::DELIVERY_DELIVERED => 'Delivered',
            self::DELIVERY_REJECTED => 'Rejected',
            default => 'Pending delivery',
        };
    }

    public function paymentStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_REFUNDED => 'Refunded',
            self::STATUS_PAID => 'Paid',
            default => 'Payment pending',
        };
    }

    public function refundStatusLabel(): ?string
    {
        if (! $this->isRefunded() && ! $this->refund_status) {
            return null;
        }

        return match ($this->refund_status) {
            'succeeded' => 'Refund complete',
            'pending' => 'Refund processing',
            'failed' => 'Refund failed',
            default => $this->isRefunded() ? 'Refunded' : null,
        };
    }
}
