<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = [
        'name', 'kana', 'category_id', 'maker_id', 'price', 'stock','good_details'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * 指定したカラムとソート方法でソートする
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $column
     * @param mixed $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrderBy($query, $column, $sort)
    {
        return $query->orderBy($column, $sort);
    }


    /**
     * 指定したカラムであいまい検索をするクエリー
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $column
     * @param mixed $where
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLike($query, $column, $where)
    {
        return $query->where($column, 'like', '%'.$where.'%');
    }

    /**
     * 商品情報をあいまい検索して結果を返す
     * @param string $column
     * @param string $column
     * @string Good|null Goodオブジェクトまたは結果0件だった場合はnull
     */
    public function getGoodSearch($column, $where)
    {
        return $this->ofLike($column, $where)->ofOrderBy('id', 'DESC')->paginate(10);
    }

    /**
     * 全ての商品を取得して$sortでソートして返す
     * 初期値は全件取得。
     * $paginateNumに数の指定があったら指定した件数でページネーションして取得して返す
     * $sortは初期値DESCです
     * @parama int id
     * @return Good
     */
    public function getGoodAll($paginateNum = 0, $sort = 'DESC')
    {
        if ($paginateNum != 0) return $this->ofOrderBy('id', $sort)->paginate($paginateNum);

        return $this->ofOrderBy('id', $sort)->all();
    }

    /**
     * idの商品情報を返す
     * @param int id
     * @return Good
     */
    public static function getGood($id)
    {
        return self::find($id);
    }

    /**
     * 商品の在庫数をアップデートします
     * @param Good $good Goodオブジェクト
     * @param int $stock アップデートする在庫数
     */
    public static function paymentGood(Good $good, $stock)
    {
        $good->stock = $stock;
        $good->save();
    }
}
