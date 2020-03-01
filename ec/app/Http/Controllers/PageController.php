<?php

namespace App\Http\Controllers;
use App\Good;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function top()
    {
        return view('ec.top');
    }

    public function show()
    {
        $goods = Good::all(); // 商品一覧をDBから取得して表示する処理をここに書く。

        // file_get_contents(http://ec.local/api/goodsRanking): failed to open stream: Connection refused
        // 上記エラーとなり取得できない。
        // おそらくDockerの設定だと思う
        // $goodsRanking = file_get_contents('http://ec.local/api/goodsRanking'); // 最近買われている商品ランキング取得
        // dd($goodsRanking);
        return view('ec.show', ['goods' => $goods]);
    }
}
