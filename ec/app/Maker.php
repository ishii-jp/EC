<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    /**
     * goodsテーブルリレーション
     * hasmany
     *
     * @return void
     */
    public function goods()
    {
        return $this->hasMany(Good::class);
    }

    /**
     * メーカーテーブル全件取得し返します
     *
     * @return Maker
     */
    public function getMakerAll()
    {
        return self::all();
    }
}
