<?php

namespace App\Http\Controllers;

use App\Good;


class PageController extends Controller
{
    /** @var Good Goodインスタンス */
    private $good;

    /**
     * __construct
     *
     * @param Good $good
     */
    public function __construct(Good $good)
    {
        $this->good = $good;
    }

    /**
     * トップ画面
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function top()
    {
        return view('ec.top');
    }

    /**
     * 商品一覧画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show()
    {
        $ret['goods'] = $this->good->getGoodAll(10); // 商品一覧を取得
        $ret['goodsRanking'] = json_decode(file_get_contents(route('goodsRanking')), true); // 人気商品ランキング取得
        return view('ec.show', $ret);
    }
}
