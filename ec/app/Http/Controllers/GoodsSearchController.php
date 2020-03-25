<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodsSearchController extends Controller
{
    private $goodsSearchService;

    public function __construct(\App\Services\GoodsSearchService $goodsSearchService)
    {
        $this->goodsSearchService = $goodsSearchService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $goodsRanking = file_get_contents('http://ec.local/api/goodsRanking'); // 人気商品ランキング取得
        $ret['goodsRanking'] = json_decode($goodsRanking, true);

        $ret['goods'] = $this->goodsSearchService->goodsSearch($request->goodsSearch);

        //　ここでgoodsSearchServiceのgoodsSearch()を実行して検索結果を返す。
        return view('ec.goodsSearches.goodsSearch', $ret);
    }
}
