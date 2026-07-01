<?php

namespace App\Http\Controllers\Concerns;

use App\Models\TicketOrder;
use Illuminate\Support\Collection;

trait LoadsUserOrders
{
    protected function userOrders(): Collection
    {
        return TicketOrder::with('worldCupMatch')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    /**
     * @return array{tickets: int, spent: float, orders: int, upcoming: int}
     */
    protected function userStats(Collection $orders): array
    {
        $paidOrders = $orders->where('status', 'paid');

        return [
            'tickets' => $paidOrders->sum('quantity'),
            'spent' => $paidOrders->sum('amount') / 100,
            'orders' => $orders->count(),
            'upcoming' => $paidOrders->filter(fn ($o) => $o->worldCupMatch?->isUpcoming())->count(),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<int>, max: int}
     */
    protected function userActivityData(Collection $orders): array
    {
        $activityBuckets = collect(range(5, 0))->map(function ($monthsAgo) use ($orders) {
            $monthStart = now()->subMonths($monthsAgo)->startOfMonth();
            $monthKey = $monthStart->format('Y-m');
            $monthOrders = $orders->filter(fn ($order) => $order->created_at->format('Y-m') === $monthKey);

            return [
                'label' => $monthStart->format('M'),
                'tickets' => $monthOrders->sum('quantity'),
            ];
        });

        return [
            'labels' => $activityBuckets->pluck('label')->all(),
            'values' => $activityBuckets->pluck('tickets')->all(),
            'max' => max($activityBuckets->pluck('tickets')->all() ?: [1]),
        ];
    }
}
