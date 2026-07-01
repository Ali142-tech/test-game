<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsUserOrders;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserAccountController extends Controller
{
    use LoadsUserOrders;

    public function dashboard(): View|RedirectResponse
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $orders = $this->userOrders();

        return view('user.dashboard', [
            'orders' => $orders,
            'stats' => $this->userStats($orders),
            'activityData' => $this->userActivityData($orders),
        ]);
    }

    public function tickets(): View|RedirectResponse
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $orders = $this->userOrders();

        return view('user.tickets', [
            'orders' => $orders,
            'paidOrders' => $orders->where('status', 'paid'),
        ]);
    }

    public function orders(): View|RedirectResponse
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('user.orders', [
            'orders' => $this->userOrders(),
        ]);
    }
}
