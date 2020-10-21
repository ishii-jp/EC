<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Good;
use App\Maker;
use Exception;
use Illuminate\Support\Facades\DB;

class MakerController extends Controller
{
    /** @var array 商品ランキング */
    private $goodsRanking;

    /** @var Maker Makerインスタンス */
    public $maker;

    /**
     * __construct
     *
     * @param Maker $maker
     */
    public function __construct(Maker $maker)
    {
        $this->maker = $maker;

        // 人気商品ランキング取得
        $this->goodsRanking = json_decode(file_get_contents('http://ec.local/api/goodsRanking'), true);
    }

    /**
     * カテゴリ一覧画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function makerIndex()
    {
        $ret['categories'] = $this->maker->getMakerAll();
        $ret['goodsRanking'] = $this->goodsRanking;
        return view('ec.categories.categoryIndex', $ret);
    }

    /**
     * 新規カテゴリー作成画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function makerAdd()
    {
        return view('ec.categories.category_add');
    }

    /**
     * カテゴリーを追加します
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function makerAddPost(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->maker->fill([
                'maker_name' => $request->input('makerName')
            ]);
            $this->maker->save();

            DB::commit();
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }

        return redirect(route('good.index'));
    }

    /**
     * カテゴリーごと商品一覧画面
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function makerShow(Request $request)
    {
        $ret['goodsRanking'] = $this->goodsRanking;
        $ret['goods'] = Good::with('maker')->where('maker_id', $request->maker_id)->paginate(10);
        return view('ec.categories.categoryShow', $ret);
    }
}
