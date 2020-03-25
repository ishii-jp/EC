<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Category;

class CategoryController extends Controller
{
    private $goodsRanking;

    public function __construct()
    {
        $goodsRanking = file_get_contents('http://ec.local/api/goodsRanking'); // 人気商品ランキング取得
        $this->goodsRanking = json_decode($goodsRanking, true);
    }

    public function categoryIndex()
    {
        $ret['categories'] = Category::all();
        $ret['goodsRanking'] = $this->goodsRanking;
        return view('ec.categories.categoryIndex', $ret);
    }

    public function categoryShow(Request $request)
    {
        $ret['goodsRanking'] = $this->goodsRanking;

        $ret['goods'] = Good::with('category')->where('category_id', $request->category_id)->paginate(10);
        return view('ec.categories.categoryShow', $ret);
    }
}
