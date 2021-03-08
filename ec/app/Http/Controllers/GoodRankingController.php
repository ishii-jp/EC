<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\PurchaseHistory;

/**
 * GoodRankingController
 */
class GoodRankingController extends Controller
{
    private $purchaseHistory;

    /**
     * __construct
     *
     * @param PurchaseHistory $purchaseHistory
     */
    public function __construct(PurchaseHistory $purchaseHistory)
    {
        $this->purchaseHistory = $purchaseHistory;
    }

    /**
     * 商品ランキング
     *
     * @return \Illuminate\Http\Response
     */
    public function goodRanking()
    {
        // 商品ランキングを返します
        if (Cache::has('purchaseHistoryRanking')) {
            return json_encode(Cache::get('purchaseHistoryRanking'));
        }

        $ranking = $this->purchaseHistory->purchaseHistoryRanking();
        Cache::put('purchaseHistoryRanking', $ranking);

        return json_encode($ranking);
    }

    /**
     * カテゴリ別商品ランキング
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @todo 現在どこからも呼ばれていないアクションです。 テーブルにカラム追加後このapiをコールする予定です
     */
    public function goodRankingByCategory(Request $request)
    {
        // カテゴリ別商品ランキングを返します
        if (Cache::has('purchaseHistoryRankingByCategory')) {
            return json_encode(Cache::get('purchaseHistoryRankingByCategory'));
        }

        $ranking = $this->purchaseHistory->purchaseHistoryRankingByCategory($request->categoryId);
        Cache::put('purchaseHistoryRankingByCategory', $ranking);

        return json_encode($ranking);
    }
}
