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
    /**
     * 商品ランキング
     *
     * @return \Illuminate\Http\Response
     */
    public function goodRanking()
    {
        $cacheKey = 'purchaseHistoryRanking';

        // 商品ランキングを返します
        if (Cache::has($cacheKey)) {
            return json_encode(Cache::get($cacheKey));
        }

        $ranking = PurchaseHistory::purchaseHistoryRanking();
        Cache::put($cacheKey, $ranking);

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
        $categoryId = $request->route('categoryId');
        $cacheKey = "purchaseHistoryRankingByCategory_{$categoryId}";

        // カテゴリ別商品ランキングを返します
        if (Cache::has($cacheKey)) {
            return json_encode(Cache::get($cacheKey));
        }

        $ranking = PurchaseHistory::purchaseHistoryRankingByCategory($categoryId);
        Cache::put($cacheKey, $ranking);

        return json_encode($ranking);
    }
}
