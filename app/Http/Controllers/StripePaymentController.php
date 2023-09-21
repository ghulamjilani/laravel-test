<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe;
// models
use App\Models\{
    Product,
    Order,
    User
};
 
class StripePaymentController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }
 
    public function session(Request $request)
    {
        $product = Product::where('id', $request->get('productId'))->first();
        $productname = $product->title ?? "Demo product";
        $totalprice = $product->price ?? "100.00";
        $two0 = "00";
        $total = "$totalprice";

        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET", "sk_test_51NsoliKAOdjeykvJdU9ZgRoLxeR9x4DsQufpmU2HvKuxstcx21BqyaF4VMsLo7cn9isgFYO9oMfDlpBqF77xBhKv00RNZRTBo2"));
 
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => (int)$total,
                    ],
                    'quantity'   => 1,
                ],
                 
            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);
 
        return redirect()->away($session->url);
    }
 
    public function success()
    {
        return "Thanks for you order You have just completed your payment. The seeler will reach out to you as soon as possible";
    }
}

