<?php
namespace App\Libs;

use App\Good;

class GoodsLibrary
{
    // 商品を新規登録するためのメソッドです。
    static function goodCreate($good)
    {
        Good::create([
            'name' => $good['name'],
            'kana' => $good['kana'],
            'category_id' => $good['category_id'],
            'maker_id' => $good['maker_id'],
            'price' => $good['price'],
            'stock' => $good['stock'],
            'good_details' => $good['good_details']
        ]);
    }

    // 商品情報を更新するためのメソッドです。
    static function goodsUpdate($goods)
    {
        foreach ($goods as $column => $ids){
            foreach ($ids as $id => $value){
                if ($column == 'category' || $column == 'maker') $column = $column. '_id';
                $goodData = Good::find($id);
                $goodData->$column = $value;
                $goodData->save();
            }
        }
    }
}