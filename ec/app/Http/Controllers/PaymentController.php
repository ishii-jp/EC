<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Cart;

class PaymentController extends Controller
{
    public function index()
    {
        $ret['cartContents'] = Cart::content();
        $ret['cartTotal'] = Cart::total();
        return view('ec.payments.payIndex', $ret);
    }

    public function pay(Request $request)
    {
        /*単発決済用のコード*/
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => Cart::total(),
                'currency' => 'jpy'
            ));

            return back();
        } catch (\Exception $ex) {
            return 'エラーメッセージ：'. $ex->getMessage();
        }
    }
}
