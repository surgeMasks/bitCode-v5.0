<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;

use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Product',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('http://localhost:5173/success'),
            'cancel_url' => url('http://localhost:5173/cancel'),
        ]);

        return response()->json(['id' => $session->url]);
    }

public function success(Request $request)
{
    $stripeSecretKey = env('STRIPE_SECRET');
    Stripe::setApiKey($stripeSecretKey);

    $endpointSecret = env('whsec_9EPj6PcclCkYP4QjYlHhvJQrQal5J69k');

    $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');

    $event = null;

    try {
        $event = Webhook::constructEvent(
            $payload, $sigHeader, $endpointSecret
        );
    } catch (SignatureVerificationException $e) {
        // Invalid signature, log the error
        Log::error('Webhook signature verification failed: ' . $e->getMessage());
        return response('Signature verification failed', 400);
    } catch (\UnexpectedValueException $e) {
        // Invalid payload
        Log::error('Webhook error while parsing basic request: ' . $e->getMessage());
        return response('Invalid payload', 400);
    }

    // Log the event for debugging
    Log::info('Received event: ' . $event->type);

    // Handle the event
    switch ($event->type) {
        case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object; // Contains a \Stripe\PaymentIntent
            // Handle successful payment intent here
            Log::info('PaymentIntent was successful: ' . $paymentIntent->id);
            break;

        case 'payment_method.attached':
            $paymentMethod = $event->data->object; // Contains a \Stripe\PaymentMethod
            // Handle successful attachment of payment method here
            Log::info('PaymentMethod was attached: ' . $paymentMethod->id);
            break;

        default:
            // Unexpected event type
            Log::error('Received unknown event type: ' . $event->type);
    }

    // Respond with a 200 status code to acknowledge receipt of the event
    return response('Event received', 200);
}
}
