<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorldCupMatch extends Model
{
    protected $fillable = [
        'stage',
        'home_team',
        'away_team',
        'match_date',
        'match_time',
        'city',
        'venue',
        'price_from',
        'tickets_available',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'match_date' => 'date',
        'is_published' => 'boolean',
        'price_from' => 'integer',
        'tickets_available' => 'integer',
    ];

    public function ticketOrders(): HasMany
    {
        return $this->hasMany(TicketOrder::class);
    }

    public function ticketsSold(): int
    {
        return (int) $this->ticketOrders()->where('status', 'paid')->sum('quantity');
    }

    public function ticketsRemaining(): ?int
    {
        if ($this->tickets_available === null) {
            return null;
        }

        return max(0, $this->tickets_available - $this->ticketsSold());
    }

    public function hasAvailability(int $quantity = 1): bool
    {
        if ($this->tickets_available === null) {
            return true;
        }

        return $this->ticketsRemaining() >= $quantity;
    }

    public function isSoldOut(): bool
    {
        return $this->tickets_available !== null && $this->ticketsRemaining() === 0;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('match_date')->orderBy('match_time')->orderBy('sort_order');
    }

    public function formattedDate(): string
    {
        return $this->match_date->format('D, M j').' · '.$this->match_time;
    }

    public function formattedShortDate(): string
    {
        return $this->match_date->format('M j');
    }

    public function formattedDayTime(): string
    {
        return $this->match_date->format('D').', '.$this->match_time;
    }

    public function stageLabel(): string
    {
        return strtoupper($this->stage);
    }

    public function matchupTitle(): string
    {
        return $this->home_team.' vs '.$this->away_team;
    }

    public function priceInCents(): int
    {
        return (int) ($this->price_from ?? 0) * 100;
    }

    public function locationLine(): string
    {
        return $this->city.' · '.$this->venue;
    }
}
