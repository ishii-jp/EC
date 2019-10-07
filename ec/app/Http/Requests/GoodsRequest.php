<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends FormRequest
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
            'name' => 'required',
            'kana' => 'required',
            'category_id' => 'required',
            'maker_id' => 'required',
            'price' => 'required | numeric',
            'stock' => 'required | numeric',
            'good_details' => 'required',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '商品名を入力して下さい',
            'kana.required'  => 'ふりがなを入力して下さい',
            'category_id.required'  => 'カテゴリー名を選択して下さい',
            'maker_id.required'  => 'メーカー名を選択して下さい',
            'price.required'  => '値段を入力して下さい',
            'price.numeric'  => '値段は数値で入力して下さい',
            'stock.required'  => '在庫を入力して下さい',
            'stock.numeric'  => '在庫は数値で入力して下さい',
            'good_details.required'  => '商品説明を入力して下さい',
        ];
    }
}
