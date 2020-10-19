<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'categoryName' => 'required|string|max:10'
        ];
    }

    public function messages()
    {
        return [
            'categoryName.required' => 'カテゴリー名は必須入力です',
            'categoryName.max' => 'カテゴリー名は10文字以内で入力してください'
        ];
    }
}
