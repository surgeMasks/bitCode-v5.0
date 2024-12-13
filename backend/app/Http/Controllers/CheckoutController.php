<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseStatusEnum;
use App\Models\Purchase;
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
    // Your secret key
    $stripeSecretKey = env('STRIPE_SECRET');
    Stripe::setApiKey($stripeSecretKey);

    // The endpoint secret from your Stripe Dashboard
    $endpointSecret = env('STRIPE_WEBHOOK');

    // Retrieve the request payload
    $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');

    // Initialize event variable
    $event = null;

    try {
        $event = Webhook::constructEvent(
            $payload, $sigHeader, $endpointSecret
        );
    } catch (SignatureVerificationException $e) {
        Log::error('Webhook signature verification failed: ' . $e->getMessage());
        // return response('Signature verification failed', 400);
    } catch (\UnexpectedValueException $e) {
        Log::error('Webhook error while parsing basic request: ' . $e->getMessage());
        // return response('Invalid payload', 400);
    }

    // Log the event for debugging
    Log::info('Received event: ' . $event->type);

    // Handle the event
    switch ($event->type) {
        case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object;
            // $payment = Purchase::where('payment_id', $paymentIntent->id)->first();
            // $payment->status = PurchaseStatusEnum::ONLINE;
            // Handle successful payment intent here
            Log::info('PaymentIntent was successful: ' . $event);
            Log::info('PaymentIntent was successful: ' . $paymentIntent->id);
            break;

        case 'payment_method.attached':
            $paymentMethod = $event->data->object;
            Log::info('PaymentMethod was attached: ' . $paymentMethod->id);
            break;

        default:
            Log::error('Received unknown event type: ' . $event->type);
    }

    // Respond with a 200 status code to acknowledge receipt of the event
    return response('Event received', 200);
}
}
