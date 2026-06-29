<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketOrder extends Model
{
    protected $fillable = [
        'user_id',
        'world_cup_match_id',
        'quantity',
        'amount',
        'status',
        'stripe_session_id',
        'payment_reference',
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
        return $this->status === 'paid';
    }
}
