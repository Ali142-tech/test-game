<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketOrder;
use App\Services\StripeRefundService;
use App\Support\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'paid' => TicketOrder::where('status', TicketOrder::STATUS_PAID)->count(),
            'pending' => TicketOrder::where('status', TicketOrder::STATUS_PENDING)->count(),
            'refunded' => TicketOrder::where('status', TicketOrder::STATUS_REFUNDED)->count(),
            'tickets_sold' => TicketOrder::where('status', TicketOrder::STATUS_PAID)->sum('quantity'),
            'revenue' => TicketOrder::where('status', TicketOrder::STATUS_PAID)->sum('amount') / 100,
            'delivery_pending' => TicketOrder::where('status', TicketOrder::STATUS_PAID)->where('delivery_status', TicketOrder::DELIVERY_PENDING)->count(),
            'delivery_delivered' => TicketOrder::where('status', TicketOrder::STATUS_PAID)->where('delivery_status', TicketOrder::DELIVERY_DELIVERED)->count(),
            'delivery_rejected' => TicketOrder::where('delivery_status', TicketOrder::DELIVERY_REJECTED)->count(),
        ];

        return view('admin.tickets.index', compact('orders', 'stats'));
    }

    public function update(Request $request, TicketOrder $ticketOrder, StripeRefundService $refunds): RedirectResponse
    {
        if ($ticketOrder->isRefunded()) {
            return back()->with(Notify::warning('This order was refunded and cannot be changed.', 'Refunded'));
        }

        if (! $ticketOrder->isPaid()) {
            return back()->with(Notify::warning('Delivery status can only be updated for paid orders.', 'Not available'));
        }

        $data = $request->validate([
            'delivery_status' => ['required', 'in:'.TicketOrder::DELIVERY_PENDING.','.TicketOrder::DELIVERY_DELIVERED.','.TicketOrder::DELIVERY_REJECTED],
            'delivery_note' => ['required_if:delivery_status,'.TicketOrder::DELIVERY_REJECTED, 'nullable', 'string', 'max:1000'],
        ]);

        if ($data['delivery_status'] === TicketOrder::DELIVERY_REJECTED) {
            if ($ticketOrder->delivery_status === TicketOrder::DELIVERY_REJECTED) {
                $ticketOrder->update(['delivery_note' => $data['delivery_note']]);

                return back()->with(Notify::success('Rejection note updated for order #'.$ticketOrder->id.'.', 'Note updated'));
            }

            try {
                $refunds->refundRejectedOrder($ticketOrder, $data['delivery_note']);
            } catch (\RuntimeException $exception) {
                return back()->with(Notify::warning($exception->getMessage(), 'Refund failed'));
            }

            return back()->with(Notify::success(
                'Order #'.$ticketOrder->id.' rejected. Payment refunded to the customer\'s card (may take 5–10 business days).',
                'Refunded'
            ));
        }

        $ticketOrder->update([
            'delivery_status' => $data['delivery_status'],
            'delivery_note' => null,
        ]);

        return back()->with(Notify::success('Ticket delivery status updated for order #'.$ticketOrder->id.'.', 'Ticket updated'));
    }
}
