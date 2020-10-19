<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Category class
 */
class Category extends Model
{
    protected $fillable = [
        'category_name'
    ];

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
     * カテゴリーテーブルを全件取得して返します
     *
     * @return Category
     */
    public function getCategoryAll()
    {
        return $this->all();
    }
}
