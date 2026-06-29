<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->where('is_admin', false)
            ->withCount(['ticketOrders as orders_count'])
            ->withSum(['ticketOrders as tickets_bought' => fn ($q) => $q->where('status', 'paid')], 'quantity')
            ->withSum(['ticketOrders as total_spent' => fn ($q) => $q->where('status', 'paid')], 'amount')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => User::where('is_admin', false)->count(),
            'with_orders' => User::where('is_admin', false)->whereHas('ticketOrders', fn ($q) => $q->where('status', 'paid'))->count(),
            'new_this_month' => User::where('is_admin', false)->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }
}
