<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'user_id', 'name', 'zip', 'address', 'tel',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function editUserInfo(array $formValue)
    {
        foreach ($formValue as $key => $value){
            if ($key != 'user_id'){
                self::updateOrcreate(
                    ['user_id' => $formValue['user_id']], [$key => $value]
                );
            }
        }
    }

    /**
     * ユーザー情報を取得して返します。
     * 存在しないuserIdだった場合はインスタンスを返します。
     *
     * @param int $userId
     * @return collection　またはインスタンス
     */
    public function getUserInfo($userId)
    {
        return self::firstOrNew(['user_id' => $userId]);
    }
}
