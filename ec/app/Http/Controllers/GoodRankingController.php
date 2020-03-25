<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return json_encode($this->purchaseHistory->purchaseHistoryRanking());
    }
}
