<?php
namespace App\Libs;

use App\Good;

class GoodsLibrary
{
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