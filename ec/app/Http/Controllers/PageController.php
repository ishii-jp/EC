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
        // 商品一覧をDBから取得して表示する処理をここに書く。
        $goods = Good::all();
        return view('ec.show', ['goods' => $goods]);
    }
}
