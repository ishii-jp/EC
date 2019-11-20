<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userInfo.name' => 'required',
            'userInfo.zip' => 'required',
            'userInfo.address' => 'required',
            'userInfo.tel' => 'required',
            'userInfo.mail' => 'required | email | confirmed',
            'userInfo.mail_confirmation' => 'required | email',
        ];
    }

    public function messages()
    {
        return [
            'userInfo.name.required' => '名前を入力して下さい',
            'userInfo.zip.required' => '郵便番号を入力して下さい',
            'userInfo.address.required' => '住所を入力して下さい',
            'userInfo.tel.required' => '電話番号を入力して下さい',
            'userInfo.mail.required' => 'メールアドレスを入力して下さい',
            'userInfo.mail_confirmation.email' => 'メールアドレス(確認用)はメールアドレスの形式で入力して下さい',
            'userInfo.mail_confirmation.required' => 'メールアドレス(確認用)を入力して下さい',
            'userInfo.mail.confirmed' => 'メールアドレスが異なります',
            'userInfo.mail.email' => 'メールアドレスはメールアドレスの形で入力して下さい',
        ];
    }
}
