<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketOrder;
use Illuminate\View\View;

class TicketOrderController extends Controller
{
    public function index(): View
    {
        $orders = TicketOrder::with(['user', 'worldCupMatch'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => TicketOrder::count(),
            'paid' => TicketOrder::where('status', 'paid')->count(),
            'pending' => TicketOrder::where('status', 'pending')->count(),
            'tickets_sold' => TicketOrder::where('status', 'paid')->sum('quantity'),
            'revenue' => TicketOrder::where('status', 'paid')->sum('amount') / 100,
        ];

        return view('admin.tickets.index', compact('orders', 'stats'));
    }
}
