<?php

namespace App\Http\Controllers;

use App\Services\GoodsSearchService;
use Illuminate\Http\Request;

class GoodsSearchController extends Controller
{
    private $goodsSearchService;

    /**
     * __construct
     *
     * @param GoodsSearchService $goodsSearchService
     */
    public function __construct(GoodsSearchService $goodsSearchService)
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
        $ret['goodsRanking'] = json_decode(file_get_contents(route('goodsRanking')), true); // 人気商品ランキング取得

        $ret['goods'] = $this->goodsSearchService->goodsSearch($request->goodsSearch);

        //　ここでgoodsSearchServiceのgoodsSearch()を実行して検索結果を返す。
        return view('ec.goodsSearches.goodsSearch', $ret);
    }
}
