<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakerRequest extends FormRequest
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
            'makerName' => 'required|string|max:20'
        ];
    }

    public function messages()
    {
        return [
            'makerName.required' => 'メーカー名は必須入力です',
            'makerName.max' => 'メーカー名は20文字以内で入力してください'
        ];
    }
}
