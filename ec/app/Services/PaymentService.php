<?php

namespace App\Services;

use App\Good;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentComplete;
use App\Mail\PaymentCompleteNotStock;
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
     * @return void
     */
    public function pay(array $cartContents, array $goods)
    {
        foreach ($cartContents as $cartContent){
            DB::beginTransaction();
            try {
                $good = $goods[$cartContent['id']];
                $newStock = $good->stock - $cartContent['qty'];
                if ($newStock < 0) $newStock = 0;

                // TODO 実際には、この辺りで決済処理を行う。(今は在庫の数を減らしているだけ)

                Good::paymentGood($good, $newStock); // 在庫の数をアップデート

                // ログインしていたら購入履歴を記録する
                if (auth()->check()) {
                    app(PurchaseHistory::class)->registPurchaseHistory($cartContent, auth()->id());
                }

                Cart::remove($cartContent['rowId']); // カートの中身を削除

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
