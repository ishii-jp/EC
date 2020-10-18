<?php

namespace App\Services;

use App\Good;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentComplete;
use App\Mail\PaymentCompleteNotStock;
use Illuminate\Support\Facades\Auth;
use App\Events\PointRegistered;
use Cart;
use Illuminate\Support\Facades\DB;
use Exception;
use App\PurchaseHistory;

/**
 * PaymentService
 */
class PaymentService
{
    /**
     * 商品購入数から在庫を引き算し、マイナスにならないことを判定
     * マイナスなら0を代入し送信するメールの種類を変更する。
     *
     * @param array $cartContents カート内商品
     * @param array $goods 商品一覧
     * @param string $totalPrice　カート内合計金額
     * @return void
     */
    public function pay(array $cartContents, array $goods, string $totalPrice)
    {
        $isLogin = Auth::check(); // ログインしているか否か

        // ログインしていたらポイントを登録する
        if ($isLogin) {
            $userId = Auth::id();
            event(new PointRegistered($totalPrice, $userId));
        }

        foreach ($cartContents as $cartContent){
            DB::beginTransaction();
            try {
                $good = $goods[$cartContent['id']];
                $newStock = $good->stock - $cartContent['qty'];
                if ($newStock < 0) $newStock = 0;
                // 実際には、この辺りで決済処理をする。
                Good::paymentGood($good, $newStock);

                // ログインしていたら購入履歴を記録する
                if ($isLogin) {
                    app(PurchaseHistory::class)->registPurchaseHistory($cartContent, $userId);
                }

                // カートの中身を削除
                Cart::remove($cartContent['rowId']);

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
                return back()->with('exception', 'エラーメッセージ：'. $e->getMessage());
            }
        }
    }
}
