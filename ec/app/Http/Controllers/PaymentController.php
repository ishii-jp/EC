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
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentComplete;
use App\Mail\PaymentCompleteNotStock;
use App\Http\Requests\UserInfoRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $ret['cartContents'] = Cart::content();
        $ret['cartTotal'] = Cart::total();
        return view('ec.payments.payIndex', $ret);
    }

    // 非会員の決算時にユーザー情報をフォームから取得
    public function registUserInfo(Request $request)
    {
        // フォーム送り先
        $ret['formAction'] = 'payPostRegistUserInfo';

        // カート内の情報はセッションに保存する
        $request->session()->put('cartContents', $request->cartContents);

        return view('ec.payments.payUserInfo', $ret);
    }

    public function postRegistUserInfo(userInfoRequest $request)
    {
        // セッションからカート内の情報を取得
        $cartContents = $request->session()->get('cartContents');

        // フォームの値を取得
        $ret['formValue'] = $request->except('_token');

        // フォーム送り先
        $ret['formAction'] = 'payPostRegistUserInfo';

        // 「修正する」ボタンが押された時の、リダイレクト処理
        if (isset($request->back)) return redirect()->route('payRegistUserInfo')->withInput();

        if (isset($request->confirm)){
            // 確認画面のビューを返す。
            $view = 'ec.payments.userInfoConfirm';
        } else {
            // ユーザー情報を登録

            // 決済処理を行うため、pay()を呼び出す
            $view = $this->pay($cartContents);
        }

        return view($view, $ret);
    }

    // 商品確認、購入数から在庫を引き算して、マイナスにならないことを判定、マイナスなら強制的に0を代入し送信するメールの種類を変更する。
    public function pay(array $cartContents)
    {
        foreach ($cartContents as $key){
            DB::beginTransaction();
            try {
                $content = Good::getGood($key['id']);
                $newStock = $content->stock - $key['qty'];
                if ($newStock < 0) $newStock = 0;
                // 実際には、この辺りで決済処理をする。
                Good::paymentGood($content, $newStock);
                DB::commit();
                // カートの中身を削除
                Cart::remove($key['rowId']);
                // 購入完了メール送信(Dockerの環境だとメールのドライバがなくエラーとなるため、コメントアウトしてます)
                if ($newStock == 0){
                    // 在庫ぎれになったバージョンのメールを送信する。
                    // Mail::to('sadaharu5goo@icloud.com')->send(new PaymentCompleteNotStock());
                } else {
                    // 普通の購入完了メールを送信する
                    // Mail::to('sadaharu5goo@icloud.com')->send(new PaymentComplete());
                }
            } catch (Exception $e){
                DB::rollback();
                $exception = 'エラーメッセージ：'. $e->getMessage();
            }
        }

        if (isset($exception)) return back()->with('exception', $exception);

        // 購入完了画面へ
        $view = 'ec.payments.payComplete';
        return $view;


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
