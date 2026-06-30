<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use App\Models\WorldCupMatch;
use App\Services\StripeCheckoutFulfillment;
use App\Support\Notify;
use App\Support\TeamFlag;
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
            return back()->with(Notify::warning('Ticket sales for this match have not opened yet.', 'Not available'));
        }

        if ($worldCupMatch->isSoldOut()) {
            return back()->with(Notify::warning('This match is sold out. Check other fixtures on the schedule.', 'Sold out'));
        }

        return view('checkout.show', [
            'match' => $worldCupMatch,
            'maxQuantity' => min(10, $worldCupMatch->ticketsRemaining() ?? 10),
            'homeFlag' => $this->teamFlagUrl($worldCupMatch->home_team),
            'awayFlag' => $this->teamFlagUrl($worldCupMatch->away_team),
        ]);
    }

    private function teamFlagUrl(string $teamName): ?string
    {
        static $teamCodes = null;

        $teamCodes ??= collect(require resource_path('data/teams.php'))->pluck('code', 'name');

        $code = $teamCodes->get($teamName);

        return $code ? TeamFlag::url($code) : null;
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
            return back()->with(Notify::warning('Not enough tickets left for that quantity. Please choose fewer tickets.', 'Limited availability'));
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

            return redirect()
                ->route('dashboard')
                ->with(Notify::success('Demo payment complete — your tickets are in your wallet.', 'Tickets booked'));
        }

        Stripe::setApiKey($stripeSecret);

        $successUrl = route('checkout.success', ['order' => $order->id])
            .'?session_id={CHECKOUT_SESSION_ID}';

        $session = Session::create([
            'mode' => 'payment',
            'customer_email' => $request->user()->email,
            'success_url' => $successUrl,
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
        $orderId = (int) $request->query('order');

        $order = TicketOrder::where('id', $orderId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($order->isPaid()) {
            return redirect()->route('dashboard');
        }

        $stripeSecret = config('services.stripe.secret');
        $sessionId = $request->query('session_id');

        if ($sessionId && str_contains($sessionId, '{')) {
            $sessionId = null;
        }

        $sessionId ??= $order->stripe_session_id;

        if ($stripeSecret && $sessionId) {
            Stripe::setApiKey($stripeSecret);
            $session = Session::retrieve($sessionId);
            $fulfillment->fulfillFromSession($session);
        }

        return redirect()
            ->route('dashboard')
            ->with(Notify::success('Payment successful! Your World Cup tickets are ready in your wallet.', 'Tickets booked'));
    }
}
