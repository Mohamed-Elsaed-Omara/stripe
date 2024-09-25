<?php

namespace App\Services;

use Stripe\StripeClient;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function createCheckoutSession($amount, $currency = 'usd', $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'T-shirt'],
                        'unit_amount' => 2000,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
        ]);
    }

    public function retrieveCheckoutSession($sessionId)
    {
        return $this->stripe->checkout->sessions->retrieve($sessionId);
    }

}
