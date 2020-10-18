<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Stripe\Stripe;
// use Stripe\Charge;
// use Stripe\Customer;
use Cart;
use App\Good;
use App\Http\Requests\UserInfoRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    /** @var User Userインスタンス */
    public $user;

    /** @var PaymentService PaymentServiceインスタンス */
    public $paymentService;

    /**
     * __construct
     *
     * @param User $user
     * @param PaymentService $paymentService
     */
    public function __construct(User $user, PaymentService $paymentService)
    {
        $this->user = $user;
        $this->paymentService = $paymentService;
    }

    /**
     * index
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $ret['cartContents'] = Cart::content();
        $ret['cartTotal'] = Cart::total();
        $ret['isCartContents'] = false;
        // カートの中身が空かどうか判定
        if ($ret['cartContents']->isNotEmpty()) $ret['isCartContents'] = true;
        return view('ec.payments.payIndex', $ret);
    }

    /**
     * registUserInfo
     * 非会員の決算時にユーザー情報をフォームから取得
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function registUserInfo(Request $request)
    {
        $ret['formAction'] = 'payPostRegistUserInfo'; // フォーム送り先
        $ret['totalPrice'] = $request->totalPrice; // 合計金額の取得

        // カート内の情報はセッションに保存する
        // リダイレクト時対策で、空に上書きを防ぐための条件です
        if($request->has('cartContents')) $request->session()->put('cartContents', $request->cartContents);
        if(!empty($request->totalPrice)) $request->session()->put('totalPrice', $request->totalPrice);

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
                $goods[$content['id']] = Good::getGoodFindId($content['id']);
            }
            $ret['goods'] = $goods;
       }
        return view('ec.payments.payUserInfo', $ret);
    }

    /**
     * postRegistUserInfo
     *
     * @param userInfoRequest $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function postRegistUserInfo(userInfoRequest $request)
    {
        $cartContents = $request->session()->get('cartContents'); // セッションからカート内の情報を取得
        $ret['formValue'] = $request->except('_token'); // フォームの値を取得
        $ret['formAction'] = 'payPostRegistUserInfo'; // フォーム送り先

        // ここで商品情報をカート情報から取得します
        foreach ($cartContents as $key){
            $goods[$key['id']] = Good::getGoodFindId($key['id']);
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
            $this->paymentService->pay($cartContents, $goods, $request->totalPrice); // 決済処理
            $view = 'ec.payments.payComplete'; // 購入完了画面へ
        }
        // ビューで使うため$retへ代入
        $ret['cartContents'] = $cartContents;
        $ret['totalPrice'] = $request->session()->get('totalPrice');

        return view($view, $ret);
    }
}
