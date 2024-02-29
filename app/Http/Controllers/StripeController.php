<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function index()
    {
        return Inertia::render('Stripe/Index');
    }

    public function checkout()
    {
        $latestStudent = Student::latest()->first();

        if ($latestStudent) {
            // Get all courses that user have
            $courses = $latestStudent->courses;

            $totalPrice = 0;

            foreach ($courses as $course) {
                $totalPrice += $course->course_price;
            }
            // Stripe wait cents value
            $totalPriceInCents = $totalPrice * 100;

            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'brl',
                            'unit_amount' => $totalPriceInCents,
                            'product_data' => [
                                'name' => 'Cursos do usuário',
                                'description' => 'Todos os cursos associados ao usuário',
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success'),
                'cancel_url' => route('stripe.cancel'),
            ]);

            return redirect($session->url);
        } else {
            return redirect()->route('stripe.cancel');
        }
    }

    public function success()
    {
        $latestStudent = Student::latest()->first();

        if ($latestStudent && $latestStudent->status === 'pendente') {
            $latestStudent->update(['status' => 'pago']);
        }

        // Renderize a página de sucesso
        return Inertia::render('Stripe/Success');
    }

    public function cancel()
    {
        return Inertia::render('Stripe/Cancel');
    }
}
