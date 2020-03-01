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
use Illuminate\Support\Facades\Auth;
use App\User;

class PaymentController extends Controller
{
    public $user;
    private $purchaseHistory;

    public function __construct(User $user, \App\PurchaseHistory $purchaseHistory)
    {
        $this->user = $user;
        $this->purchaseHistory = $purchaseHistory;
    }

    public function index()
    {
        $ret['cartContents'] = Cart::content();
        $ret['cartTotal'] = Cart::total();
        $ret['isCartContents'] = false;
        // カートの中身が空かどうか判定
        if ($ret['cartContents']->isNotEmpty()) $ret['isCartContents'] = true;
        return view('ec.payments.payIndex', $ret);
    }

    // 非会員の決算時にユーザー情報をフォームから取得
    public function registUserInfo(Request $request)
    {
        // フォーム送り先
        $ret['formAction'] = 'payPostRegistUserInfo';

        // カート内の情報はセッションに保存する
        // リダイレクト時対策で、空に上書きを防ぐための条件です
        if($request->has('cartContents')) $request->session()->put('cartContents', $request->cartContents);

         // ログインしてるかどうかで条件分岐
         if (Auth::check()){
            // ログインしていれば$ret['formValue']にDBから情報を格納する
            $getUser = $this->user->getUser(Auth::user()->id);
            $ret['loginFlg'] = true;
            $ret['formAction'] = 'payPostRegistUserInfo';
            $ret['formValue']['userInfo']['name'] = $getUser->userInfo->name;
            $ret['formValue']['userInfo']['zip'] = $getUser->userInfo->zip;
            $ret['formValue']['userInfo']['address'] = $getUser->userInfo->address;
            $ret['formValue']['userInfo']['tel'] = $getUser->userInfo->tel;
            $ret['formValue']['userInfo']['mail'] = $getUser->email;
            $ret['formValue']['userInfo']['mail_confirmation'] = $getUser->email;

            // 商品情報を$goodsへ格納する
            $ret['cartContents'] = session()->get('cartContents');
            foreach ($ret['cartContents'] as $content){
                $goods[$content['id']] = Good::getGood($content['id']);
            }
            $ret['goods'] = $goods;
       }

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

        // ここで商品情報をカート情報から取得します
        foreach ($cartContents as $key){
            $goods[$key['id']] = Good::getGood($key['id']);
        }
        $ret['goods'] = $goods;

        if (Auth::check()){
            // 「戻る」ボタンが押された時の、リダイレクト処理
            if ($request->filled('back')) return redirect()->route('pay');
        } else {
            // 「修正する」ボタンが押された時の、リダイレクト処理
            if ($request->filled('back')) return redirect()->route('payRegistUserInfo')->withInput();
        }

        if ($request->filled('confirm')){
            // 確認画面のビューを返す
            $view = 'ec.payments.payUserInfo';
        } else {
            // ユーザー情報を登録

            // 決済処理を行うため、pay()を呼び出す
            $view = $this->pay($cartContents, $ret['goods']);
        }
        // ビューで使うため$retへ代入
        $ret['cartContents'] = $cartContents;

        return view($view, $ret);
    }

    // 商品確認、購入数から在庫を引き算して、マイナスにならないことを判定、マイナスなら強制的に0を代入し送信するメールの種類を変更する。
    public function pay(array $cartContents, array $goods)
    {
        foreach ($cartContents as $key){
            DB::beginTransaction();
            try {
                $content = $goods[$key['id']];
                $newStock = $content->stock - $key['qty'];
                if ($newStock < 0) $newStock = 0;
                // 実際には、この辺りで決済処理をする。
                Good::paymentGood($content, $newStock);

                // ログインしていたら購入履歴を記録する
                if (Auth::check()) $this->purchaseHistory->registPurchaseHistory($key, Auth::id());

                // カートの中身を削除
                Cart::remove($key['rowId']);
                // 購入完了メール送信(Dockerの環境だとメールのドライバがなくエラーとなるため、一先ずコメントアウトしてます)
                if ($newStock == 0){
                    // 在庫ぎれになったバージョンのメールを送信する。
                    // Mail::to('sadaharu5goo@icloud.com')->send(new PaymentCompleteNotStock());
                } else {
                    // 普通の購入完了メールを送信する
                    // Mail::to('sadaharu5goo@icloud.com')->send(new PaymentComplete());
                }
                DB::commit();
            } catch (Exception $e){
                report($e);
                DB::rollback();
                $exception = 'エラーメッセージ：'. $e->getMessage();
            }
        }

        if (isset($exception)) return back()->with('exception', $exception);

        // 購入完了画面へ
        $view = 'ec.payments.payComplete';
        return $view;
    }
}
