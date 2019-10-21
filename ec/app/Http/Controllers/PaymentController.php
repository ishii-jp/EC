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

            // $customer = Customer::create(array(
            //     'email' => $request->stripeEmail,
            //     'source' => $request->stripeToken
            // ));

            $charge = Charge::create(array(
                // 'customer' => $customer->id,
                'amount' => Cart::total(),
                'currency' => 'jpy'
            ));

            return back();
        } catch (\Exception $ex) {
            return 'エラーメッセージ：'. $ex->getMessage();
        }
    }

    // public function pay(Request $request){
    //     Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    //     $token = $request->stripeToken;
    //     $charge = Charge::create([
    //         'amount' => 100,//課金額を指定
    //         'currency' => 'jpy',//通貨を指定
    //         'source' => $token,//公開鍵を指定
    //         'description' => 'Example charge'//課金内容についての説明
    //     ]);
    //     return back();
    // }
}
