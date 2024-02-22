<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{

    public function index()
    {
        return Inertia::render('Stripe/Index');
    }
    public function checkout()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'brl',
                        'unit_amount' => 2000, // Valor em centavos
                        'product_data' => [
                            'name' => 'Curso de exemplo',
                            'description' => 'Descrição do curso',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        // Retorne um redirecionamento Inertia para a página de sucesso
        return redirect()->route('stripe.success');
    }

    // Screen of success transition and Cancel
    public function success()
    {
        return Inertia::render('Stripe/Success');
    }

    public function cancel()
    {
        return Inertia::render('Stripe/Cancel');
    }
}
