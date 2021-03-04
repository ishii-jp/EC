<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\purchaseHistory;

/**
 * GoodRankingController
 */
class GoodRankingController extends Controller
{
    private $purchaseHistory;

    /**
     * __construct
     *
     * @param purchaseHistory $purchaseHistory
     */
    public function __construct(purchaseHistory $purchaseHistory)
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
        // if (Cache::has('purchaseHistoryRanking')) {
        //     return json_encode(Cache::get('purchaseHistoryRanking'));
        // }

        $ranking = $this->purchaseHistory->purchaseHistoryRanking();
        // Cache::put('purchaseHistoryRanking', $ranking);

        return json_encode($ranking);
    }

    /**
     * カテゴリ別商品ランキング
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function goodRankingByCategory(Request $request)
    {
        // カテゴリ別商品ランキングを返します
        if (Cache::has('purchaseHistoryRankingByCategory')) {
            return json_encode(Cache::get('purchaseHistoryRankingByCategory'));
        }

        $ranking = $this->purchaseHistory->purchaseHistoryRankingByCategory();
        Cache::put('purchaseHistoryRankingByCategory', $ranking);

        return json_encode($ranking);
    }
}
