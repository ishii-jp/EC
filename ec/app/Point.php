<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ポイントを取得して返します
     * @param int user_id
     * @return Point|null
     */
    public function getPoint($user_id)
    {
        return $this->where('user_id', $user_id)->first();
    }

    /**
     * ポイントを登録または追加します
     * @param int user_id
     * @param int point
     */
    public function updateOrCreatePoint($user_id, int $point)
    {
        $this::updateOrCreate(['user_id' => $user_id], ['point' => $point]);
    }
}
