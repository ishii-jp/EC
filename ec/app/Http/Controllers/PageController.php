<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private $purchaseHistory;
    private $good;

    public function __construct(\App\purchaseHistory $purchaseHistory, \App\Good $good)
    {
        $this->purchaseHistory = $purchaseHistory;
        $this->good = $good;
    }

    public function top()
    {
        return view('ec.top');
    }

    public function show()
    {
        $ret['goods'] = $this->good->getGoodAll(10); // 商品一覧を取得

        $goodsRanking = file_get_contents('http://ec.local/api/goodsRanking'); // 人気商品ランキング取得
        $ret['goodsRanking'] = json_decode($goodsRanking, true);

        return view('ec.show', $ret);
    }
}
