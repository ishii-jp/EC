<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    protected $fillable = ['user_id', 'good_id', 'qty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    /**
     * ログインしているユーザーの購入履歴を取得し返します。
     * @param int $userId
     * @param string|array リレーションデータの Eager Loadingするために指定する、初期値はgood。複数指定する場合は配列で指定
     * @return array 購入履歴
     */
    public function getPurchaseHistory($userId, $withTables = 'good')
    {
        return $this::with($withTables)->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * 購入履歴を登録する
     * @param array $items 購入した商品
     * @param int $userId ログインしているユーザーid
     */
    public function registPurchaseHistory(array $items, int $userId)
    {
        $this::create([
            'user_id' => $userId,
            'good_id' => $items['id'],
            'qty' => $items['qty']
        ]);
    }

    /**
     * 購入履歴から最も多く購入されている商品ランキングを取得して返す
     * @return collection ランキング結果のコレクション、purchase_historiesにレコードがなければ空のコレクション
     */
    public function purchaseHistoryRanking()
    {
        return $this::select(\DB::raw('count(*) as purchase_history_count, good_id'))
        ->groupBy('good_id')
        ->orderBy('purchase_history_count', 'DESC')
        ->get();
    }
}
