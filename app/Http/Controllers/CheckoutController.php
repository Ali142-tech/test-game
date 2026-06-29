<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use App\Models\WorldCupMatch;
use App\Services\StripeCheckoutFulfillment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function show(Request $request, WorldCupMatch $worldCupMatch): View|RedirectResponse
    {
        if (! $worldCupMatch->is_published) {
            abort(404);
        }

        if (! $worldCupMatch->price_from) {
            return back()->with('error', 'Tickets are not available for this match yet.');
        }

        if ($worldCupMatch->isSoldOut()) {
            return back()->with('error', 'This match is sold out.');
        }

        return view('checkout.show', [
            'match' => $worldCupMatch,
            'maxQuantity' => min(10, $worldCupMatch->ticketsRemaining() ?? 10),
        ]);
    }

    public function pay(Request $request, WorldCupMatch $worldCupMatch): RedirectResponse
    {
        if (! $worldCupMatch->is_published || ! $worldCupMatch->price_from) {
            abort(404);
        }

        $maxQuantity = min(10, $worldCupMatch->ticketsRemaining() ?? 10);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$maxQuantity],
        ]);

        if (! $worldCupMatch->hasAvailability($data['quantity'])) {
            return back()->with('error', 'Not enough tickets available for this match.');
        }

        $amountCents = $worldCupMatch->priceInCents() * $data['quantity'];

        $order = TicketOrder::create([
            'user_id' => $request->user()->id,
            'world_cup_match_id' => $worldCupMatch->id,
            'quantity' => $data['quantity'],
            'amount' => $amountCents,
            'status' => 'pending',
        ]);

        $stripeSecret = config('services.stripe.secret');

        if (! $stripeSecret) {
            $order->update([
                'status' => 'paid',
                'payment_reference' => 'demo-'.uniqid(),
            ]);

            return redirect()->route('dashboard')->with('status', 'Demo payment completed. Ticket saved to your dashboard.');
        }

        Stripe::setApiKey($stripeSecret);

        $session = Session::create([
            'mode' => 'payment',
            'customer_email' => $request->user()->email,
            'success_url' => route('checkout.success', ['order' => $order->id]).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.show', $worldCupMatch),
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $amountCents,
                    'product_data' => [
                        'name' => $worldCupMatch->matchupTitle(),
                        'description' => $worldCupMatch->stageLabel().' · '.$worldCupMatch->locationLine().' · '.$data['quantity'].' ticket(s)',
                    ],
                ],
            ]],
            'metadata' => [
                'order_id' => (string) $order->id,
            ],
        ]);

        $order->update(['stripe_session_id' => $session->id]);

        return redirect()->away($session->url);
    }

    public function success(Request $request, StripeCheckoutFulfillment $fulfillment): RedirectResponse
    {
        $order = TicketOrder::where('id', $request->query('order'))
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($order->isPaid()) {
            return redirect()->route('dashboard');
        }

        $stripeSecret = config('services.stripe.secret');
        $sessionId = $request->query('session_id');

        if ($stripeSecret && $sessionId) {
            Stripe::setApiKey($stripeSecret);
            $session = Session::retrieve($sessionId);
            $fulfillment->fulfillFromSession($session);
        }

        return redirect()->route('dashboard')->with('status', 'Payment received. Your tickets are in your dashboard.');
    }
}
