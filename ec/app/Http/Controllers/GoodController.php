<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Category;
use App\Maker;
use App\Libs\GoodsLibrary;
use Illuminate\Support\Facades\DB;
use Exception;

class GoodController extends Controller
{
    public function goodIndex()
    {
        // 商品情報を取得
        $ret['goods'] = Good::with(['category', 'maker'])->get();

        // カテゴリーを取得
        $ret['categories'] = Category::all();

        // メーカーを取得
        $ret['makers'] = Maker::all();
        return view('ec.goods.goodIndex', $ret);
    }

    public function goodAdd()
    {
        //新規商品登録する処理をここに書く
        // カテゴリーを取得
        $ret['categories'] = Category::all();

        // メーカーを取得
        $ret['makers'] = Maker::all();

        return view('ec.goods.goodAdd', $ret);
    }

    public function goodCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            GoodsLibrary::goodCreate($request->all());
            DB::commit();
        } catch (Exception $e){
            DB::rollback();
            $ret['exception'] = 'エラーメッセージ：'. $e->getMessage();
        }
        $ret['msg'] = '登録が完了しました。';
        return redirect()->route('goodAdd')->with($ret);
    }

    public function goodShow(Request $request)
    {
        $good = Good::find($request->good_id);
        return view('ec.goods.goodShow', ['good' => $good]);
    }

    public function goodUpdate(Request $request)
    {
        // トランザクションと例外処理を追記する。
        // DB::transaction(function () use ($request) {
        //     GoodsLibrary::goodsUpdate($request->goods);
        // });

        DB::beginTransaction();
        try {
            GoodsLibrary::goodsUpdate($request->goods);
            DB::commit();
        } catch (Exception $e){
            DB::rollback();
            $ret['exception'] = 'エラーメッセージ：'. $e->getMessage();
        }
        $ret['msg'] = '更新が完了しました。';
        return redirect()->route('goodIndex')->with($ret);
    }
}
