<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketOrder;
use App\Models\User;
use App\Models\WorldCupMatch;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $paidOrders = TicketOrder::query()->where('status', 'paid');

        $stats = [
            'revenue' => (clone $paidOrders)->sum('amount') / 100,
            'tickets_sold' => (clone $paidOrders)->sum('quantity'),
            'orders_paid' => (clone $paidOrders)->count(),
            'orders_pending' => TicketOrder::where('status', 'pending')->count(),
            'buyers' => (clone $paidOrders)->distinct('user_id')->count('user_id'),
            'matches_total' => WorldCupMatch::count(),
            'matches_published' => WorldCupMatch::where('is_published', true)->count(),
            'users_total' => User::where('is_admin', false)->count(),
        ];

        $recentOrders = TicketOrder::with(['user', 'worldCupMatch'])
            ->latest()
            ->limit(10)
            ->get();

        $salesTrendBuckets = collect(range(5, 0))->map(function ($monthsAgo) {
            $monthStart = now()->subMonths($monthsAgo)->startOfMonth();
            $monthKey = $monthStart->format('Y-m');
            $monthSales = TicketOrder::query()
                ->where('status', 'paid')
                ->whereBetween('created_at', [$monthStart->copy()->startOfDay(), $monthStart->copy()->endOfMonth()->endOfDay()])
                ->get();

            return [
                'label' => $monthStart->format('M'),
                'revenue' => $monthSales->sum('amount') / 100,
                'orders' => $monthSales->count(),
            ];
        });

        $salesTrend = [
            'labels' => $salesTrendBuckets->pluck('label')->all(),
            'values' => $salesTrendBuckets->pluck('revenue')->all(),
            'max' => max($salesTrendBuckets->pluck('revenue')->all() ?: [1]),
        ];

        $matchInventory = WorldCupMatch::query()
            ->withSum(['ticketOrders as tickets_sold' => fn ($q) => $q->where('status', 'paid')], 'quantity')
            ->ordered()
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'matchInventory', 'salesTrend'));
    }
}
