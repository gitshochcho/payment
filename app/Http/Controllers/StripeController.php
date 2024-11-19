<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
        $subscription = null;
        $checkout = null;
        return view('welcome',compact('subscription','checkout'));
    }

    public function stripeSubscripbe()
    {
        $stripe = new \Stripe\StripeClient('sk_test_51KOFikFc0lmoA84nRjf7U2V8RPgslalbjNQ8iFbV2kXDBhn5jlhAhQRlJMmPVxq4cDjVLl3L4Vlgd0dzG0Pw4bVp00pagMFqJh');

        $paymentMethod = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 12,
                'exp_year' => 2025,
                'cvc' => '123',
            ],
        ]);



        $customerValue = $stripe->paymentMethods->attach(
            $paymentMethod->id,
            ['customer' => 'cus_RAqcXaP3UslRDa']
        );


          $subscription = $stripe->subscriptions->create([
            'customer' => 'cus_RAqcXaP3UslRDa',
            'items' => [['price' => 'price_1MoUlAFc0lmoA84nGMTZ9c1j']],
            'default_payment_method' => $paymentMethod->id
            ]);
          $checkout = null;

          return view('welcome',compact('subscription','checkout'));
    }
    public function cancelStripeSubscripbe($subId)
    {
        $stripe = new \Stripe\StripeClient('sk_test_51KOFikFc0lmoA84nRjf7U2V8RPgslalbjNQ8iFbV2kXDBhn5jlhAhQRlJMmPVxq4cDjVLl3L4Vlgd0dzG0Pw4bVp00pagMFqJh');
        $subscription = $stripe->subscriptions->cancel($subId, []);
        $checkout = null;

          return view('welcome',compact('subscription','checkout'));
    }

    public function checkout()
    {
        $stripe = new \Stripe\StripeClient('sk_test_51KOFikFc0lmoA84nRjf7U2V8RPgslalbjNQ8iFbV2kXDBhn5jlhAhQRlJMmPVxq4cDjVLl3L4Vlgd0dzG0Pw4bVp00pagMFqJh');
        $checkoutSession = $stripe->checkout->sessions->create([
            'success_url' => route('success-url'). '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('fail-url'),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Sample Product',
                        ],
                        'unit_amount' => 50000,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
          ]);

          return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $productId = $request->query('session_id');
        $subscription = null;
        $checkout = "success";

        $stripe = new \Stripe\StripeClient('sk_test_51KOFikFc0lmoA84nRjf7U2V8RPgslalbjNQ8iFbV2kXDBhn5jlhAhQRlJMmPVxq4cDjVLl3L4Vlgd0dzG0Pw4bVp00pagMFqJh');
        $checkoutSession = $stripe->checkout->sessions->retrieve($productId, []);

    // Access session details
        $transactionId = $checkoutSession->payment_intent;
        $customerDetails = $checkoutSession->customer_details;
        return view('welcome',compact('subscription','checkout','transactionId','customerDetails'));
    }

    public function fail(Request $request)
    {
        $subscription = null;
        $checkout = "fail";
        return view('welcome',compact('subscription','checkout'));
    }
}
