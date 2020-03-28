<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GoodRankingController extends Controller
{
    private $purchaseHistory;

    public function __construct(\App\purchaseHistory $purchaseHistory)
    {
        $this->purchaseHistory = $purchaseHistory;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // 商品ランキングを返します
        if (Cache::has('purchaseHistoryRanking')) return json_encode(Cache::get('purchaseHistoryRanking'));

        $ranking = $this->purchaseHistory->purchaseHistoryRanking();
        Cache::put('purchaseHistoryRanking', $ranking);

        return json_encode($ranking);
    }
}
