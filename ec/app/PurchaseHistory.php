<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
     * 
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
     * 
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
     * 購入履歴から最も多く購入されている商品ランキングを15件取得して返す
     * 
     * @return collection ランキング結果のコレクション、purchase_historiesにレコードがなければ空のコレクション
     */
    public function purchaseHistoryRanking($withTables = 'good')
    {
        return $this::with($withTables)->select(DB::raw('count(*) as purchase_history_count, good_id'))
        ->groupBy('good_id')
        ->orderBy('purchase_history_count', 'DESC')
        ->limit(15)
        ->get();
    }

    /**
     * 購入履歴から最も多く購入されている商品ランキングを15件取得して返す
     * 
     * categoryIdがnullまたはDBに一つも合致するものがなければ空のコレクションを返します。
     *
     * @param string|null $categoryId 取得したいランキングのカテゴリID
     * @return collection ランキング結果のコレクション
     */
    public function purchaseHistoryRankingByCategory(?string $categoryId, $withTables = 'good')
    {
        if (is_null($categoryId)) {
            return new Collection;
        }

        return $this::with($withTables)
        ->where('category_id', $categoryId)
        ->select(DB::raw('count(*) as purchase_history_count, good_id'))
        ->groupBy('good_id')
        ->orderBy('purchase_history_count', 'DESC')
        ->limit(15)
        ->get();
    }
}
