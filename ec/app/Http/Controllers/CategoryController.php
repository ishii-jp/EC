<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Category;

class CategoryController extends Controller
{
    /** @var array 商品ランキング */
    private $goodsRanking;

    /** @var Category Categoryインスタンス */
    public $category;

    /**
     * __construct
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->goodsRanking = json_decode(file_get_contents('http://ec.local/api/goodsRanking'), true); // 人気商品ランキング取得
    }

    public function categoryIndex()
    {
        $ret['categories'] = $this->category->getCategoryAll();
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
