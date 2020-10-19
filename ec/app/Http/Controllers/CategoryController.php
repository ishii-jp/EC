<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Good;
use App\Category;
use Exception;
use Illuminate\Support\Facades\DB;

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

        // 人気商品ランキング取得
        $this->goodsRanking = json_decode(file_get_contents('http://ec.local/api/goodsRanking'), true);
    }

    /**
     * カテゴリ一覧画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function categoryIndex()
    {
        $ret['categories'] = $this->category->getCategoryAll();
        $ret['goodsRanking'] = $this->goodsRanking;
        return view('ec.categories.categoryIndex', $ret);
    }

    /**
     * 新規カテゴリー作成画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function categoryAdd()
    {
        return view('ec.categories.category_add');
    }

    /**
     * カテゴリーを追加します
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function categoryAddPost(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->category->fill([
                'category_name' => $request->input('categoryName')
            ]);
            $this->category->save();

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
    public function categoryShow(Request $request)
    {
        $ret['goodsRanking'] = $this->goodsRanking;
        $ret['goods'] = Good::with('category')->where('category_id', $request->category_id)->paginate(10);
        return view('ec.categories.categoryShow', $ret);
    }
}
