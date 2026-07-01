<?php

namespace App\Models;

use App\Support\MatchKickoff;
use App\Support\VenueTimezone;
use Carbon\CarbonInterface;
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
        'starts_at',
        'timezone',
        'city',
        'venue',
        'price_from',
        'tickets_available',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'match_date' => 'date',
        'starts_at' => 'datetime',
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

    public function scopeUpcoming($query)
    {
        return $query->where(function ($query) {
            $query->where('starts_at', '>', now())
                ->orWhere(function ($query) {
                    $query->whereNull('starts_at')
                        ->whereDate('match_date', '>=', now()->toDateString());
                });
        });
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderByRaw('starts_at IS NULL')
            ->orderBy('starts_at')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->orderBy('sort_order');
    }

    public function kickoffAtUtc(): ?CarbonInterface
    {
        if ($this->starts_at) {
            return $this->starts_at->copy()->utc();
        }

        if (! $this->match_date || ! $this->match_time || ! $this->city) {
            return null;
        }

        return MatchKickoff::buildUtc(
            $this->match_date->format('Y-m-d'),
            $this->match_time,
            $this->city,
        )['starts_at'];
    }

    public function kickoffAtVenue(): ?CarbonInterface
    {
        $utc = $this->kickoffAtUtc();

        if (! $utc) {
            return null;
        }

        return $utc->copy()->timezone($this->timezone ?? VenueTimezone::forCity($this->city ?? ''));
    }

    public function isUpcoming(): bool
    {
        return $this->kickoffAtUtc()?->isFuture() ?? $this->match_date?->endOfDay()->isFuture() ?? false;
    }

    public function kickoffIso(): ?string
    {
        return $this->kickoffAtUtc()?->toIso8601String();
    }

    public function formattedDate(): string
    {
        return $this->formattedVenueKickoff();
    }

    public function formattedShortDate(): string
    {
        return $this->kickoffAtVenue()?->format('M j') ?? $this->match_date->format('M j');
    }

    public function formattedDayTime(): string
    {
        return $this->formattedVenueKickoff();
    }

    public function formattedVenueKickoff(): string
    {
        $venue = $this->kickoffAtVenue();

        if ($venue) {
            return $venue->format('D').', '.$venue->format('g:ia').' '.$venue->format('T');
        }

        return $this->match_date->format('D').', '.$this->match_time;
    }

    public function formattedVenueDateLong(): string
    {
        $venue = $this->kickoffAtVenue();

        if ($venue) {
            return $venue->format('l, F j, Y');
        }

        return $this->match_date->format('l, F j, Y');
    }

    public function formattedVenueTime(): string
    {
        $venue = $this->kickoffAtVenue();

        if ($venue) {
            return $venue->format('g:ia').' '.$venue->format('T').' (stadium)';
        }

        return $this->match_time;
    }

    public function syncKickoffFields(): void
    {
        if (! $this->match_date || ! $this->match_time || ! $this->city) {
            return;
        }

        $kickoff = MatchKickoff::buildUtc(
            $this->match_date->format('Y-m-d'),
            $this->match_time,
            $this->city,
        );

        $this->starts_at = $kickoff['starts_at'];
        $this->timezone = $kickoff['timezone'];
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
