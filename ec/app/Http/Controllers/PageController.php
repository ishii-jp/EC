<?php

namespace App\Http\Controllers;
use App\Good;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private $purchaseHistory;

    public function __construct(\App\purchaseHistory $purchaseHistory)
    {
        $this->purchaseHistory = $purchaseHistory;
    }

    public function top()
    {
        return view('ec.top');
    }

    public function show()
    {
        $ret['goods'] = Good::all(); // 商品一覧を取得

        // $goodsRanking = file_get_contents('http://ec.local/api/goodsRanking'); // 人気商品ランキング取得
        $ret['goodsRanking'] = $this->purchaseHistory->purchaseHistoryRanking(); // 人気商品ランキング取得

        return view('ec.show', $ret);
    }
}
