<?php
namespace App\Services;

class GoodsSearchService
{
    private $good;

    public function __construct(\App\Good $good)
    {
        $this->good = $good;
    }

    public function goodsSearch($goodsSearch)
    {
        return $this->good->getGoodSearch('name', $goodsSearch);
    }
}