<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakerRequest;
use Illuminate\Http\Request;
use App\Maker;
use Exception;
use Illuminate\Support\Facades\DB;

class MakerController extends Controller
{
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
    }

    /**
     * 新規カテゴリー作成画面
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function makerAdd()
    {
        return view('ec.makers.maker_add');
    }

    /**
     * メーカーを追加します
     *
     * @param MakerRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function makerAddPost(MakerRequest $request)
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
}
