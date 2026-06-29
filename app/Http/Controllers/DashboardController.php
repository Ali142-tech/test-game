<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $orders = TicketOrder::with('worldCupMatch')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $paidOrders = $orders->where('status', 'paid');

        $stats = [
            'tickets' => $paidOrders->sum('quantity'),
            'spent' => $paidOrders->sum('amount') / 100,
            'orders' => $orders->count(),
            'upcoming' => $paidOrders->filter(fn ($o) => $o->worldCupMatch?->match_date?->isFuture())->count(),
        ];

        $activityBuckets = collect(range(5, 0))->map(function ($monthsAgo) use ($orders) {
            $monthStart = now()->subMonths($monthsAgo)->startOfMonth();
            $monthKey = $monthStart->format('Y-m');
            $monthOrders = $orders->filter(fn ($order) => $order->created_at->format('Y-m') === $monthKey);

            return [
                'label' => $monthStart->format('M'),
                'tickets' => $monthOrders->sum('quantity'),
                'orders' => $monthOrders->count(),
            ];
        });

        $activityData = [
            'labels' => $activityBuckets->pluck('label')->all(),
            'values' => $activityBuckets->pluck('tickets')->all(),
            'max' => max($activityBuckets->pluck('tickets')->all() ?: [1]),
        ];

        return view('dashboard', compact('orders', 'stats', 'activityData'));
    }
}
