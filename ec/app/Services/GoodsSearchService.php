<?php
namespace App\Services;

class GoodsSearchService
{
    public function goodsSearch($goodsSearch)
    {
        return \App\Good::where('name', 'like', '%'.$goodsSearch.'%')->orderBy('id', 'DESC')->get();
    }
}