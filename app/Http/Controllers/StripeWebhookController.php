<?php

namespace App\Http\Controllers;

use App\Services\StripeCheckoutFulfillment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripeCheckoutFulfillment $fulfillment): JsonResponse
    {
        $webhookSecret = config('services.stripe.webhook_secret');

        if (! $webhookSecret) {
            Log::error('Stripe webhook received but STRIPE_WEBHOOK_SECRET is not set');

            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        if (! $signature) {
            return response()->json(['error' => 'Missing Stripe-Signature header'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $signature, $webhookSecret);
        } catch (SignatureVerificationException $exception) {
            Log::warning('Stripe webhook signature verification failed', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $exception) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
            case 'checkout.session.async_payment_succeeded':
                $fulfillment->fulfillFromSession($event->data->object);
                break;
        }

        return response()->json(['received' => true]);
    }
}
