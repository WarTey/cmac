<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        Stripe::setApiKey(config('stripe.secret_key'));
        // TODO : Add user and more information (course)
        $intent = PaymentIntent::create([
            'amount' => $request->post('price'),
            'currency' => 'EUR',
            'description' => $request->post('uuid'),
        ]);

        return [
            'success' => true,
            'secret' => $intent->client_secret
        ];
    }
}
