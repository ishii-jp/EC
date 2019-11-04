<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Stripe\Stripe;
// use Stripe\Charge;
// use Stripe\Customer;
use Cart;
use App\Good;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentController extends Controller
{
    public function index()
    {
        $ret['cartContents'] = Cart::content();
        $ret['cartTotal'] = Cart::total();
        return view('ec.payments.payIndex', $ret);
    }

    // 商品確認、購入数から在庫を引き算して、マイナスにならないことを判定、マイナスなら強制的に0を代入し送信するメールの種類を変更する。
    public function pay(Request $request)
    {
        foreach ($request->cartContents as $key){
            DB::beginTransaction();
            try {
                $content = Good::getGood($key['id']);
                $newStock = $content->stock - $key['qty'];
                if ($newStock < 0) $newStock = 0;
                Good::paymentGood($conten, $newStock);
                DB::commit();
                // カートの中身を削除
                Cart::remove($key['rowId']);
                // 購入完了メール送信
                if ($newStock == 0){
                    // 在庫ぎれになったバージョンのメールを送信する。
                } else {
                    // 普通の購入完了メールを送信する
                }
            } catch (Exception $e){
                DB::rollback();
                $exception = 'エラーメッセージ：'. $e->getMessage();
            }
        }

        if (isset($exception)){
            return back()->with('exception', $exception);
        }
        // 購入完了画面へ遷移
        return view('ec.payments.payComplete');


        // stripeのエラーが謎すぎて打つ手がないので、自作の決済を実装します。
        /*単発決済用のコード*/
        // try {
        //     Stripe::setApiKey(env('STRIPE_SECRET'));

        //     // $customer = Customer::create(array(
        //     //     'email' => $request->stripeEmail,
        //     //     'source' => $request->stripeToken
        //     // ));

        //     $charge = Charge::create(array(
        //         // 'customer' => $customer->id,
        //         'amount' => Cart::total(),
        //         'currency' => 'jpy'
        //     ));

        //     return back();
        // } catch (\Exception $ex) {
        //     return 'エラーメッセージ：'. $ex->getMessage();
        // }
    }

    // public function pay(Request $request){
    //     Stripe::setApiKey(env('STRIPE_SECRET'));
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
