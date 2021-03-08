<?php

namespace App\Http\Controllers;

use App\Good;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Request $request)
    {
        $ret['goods'] = $this->good->getGoodAll(10); // 商品一覧を取得
        $ret['goodsRanking'] = json_decode(file_get_contents("http://{$request->header('host')}/api/goodsRanking"), true); // 人気商品ランキング取得

        return view('ec.show', $ret);
    }
}
