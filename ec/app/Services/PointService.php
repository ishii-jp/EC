<?php
namespace App\Services;

class PointService
{
    /**
     * 購入金額からポイントを計算して返します。
     * @param int price
     * @return int point
     */
    public function pointCalculation(int $price)
    {
        $point = 0;
        if ($price > 1000) $point = (int)ceil($price / 100);
        return $point;
    }

    /**
     * 現在のポイントと購入して得たポイントを合算します。
     * @param int addPoint 追加するポイント
     * @param int pointNow 現在のポイント
     * @return int 合算したポイント
     */
    public function pointSum(int $addPoint, int $pointNow)
    {
        return $addPoint + $pointNow;
    }
}