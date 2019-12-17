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

    public function getUserInfo($user_id)
    {
        return self::where('user_id', $user_id)->first();
    }
}
