<?php
namespace App\Services;

use App\Good;
class GoodsSearchService
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
     * 商品検索結果を返します
     *
     * @param string|null $goodsSearch 検索文字
     * @return Good|null 検索結果
     */
    public function goodsSearch(?string $goodsSearch)
    {
        return $this->good->getGoodSearch('name', $goodsSearch);
    }
}