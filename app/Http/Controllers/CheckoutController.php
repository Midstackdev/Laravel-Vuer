<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index(){
    	return view('checkout');
    }


    public function stripe(){
    	return view('stripe');
    }

    public function stripePayment(Request $request){
		Stripe::setApiKey('sk_test_2mFP4EpQb3k593C6XW3RqFX500Ii1uUXGE');
		Charge::create([
		    'amount' => $request->get('total'),
		    'currency' => 'usd',
		    'description' => 'Example charge',
		    'source' => $request->get('stripeToken'),
		    'receipt_email' => $request->get('email'),
		    'metadata' => [
		    	'order_id' => 45654,
		    ]
		]);

		// Save customer and order details to databse
		return back()->with('success_message', 'Thank you your payment has been accepted');
    }
}
