<?php

namespace Tests\Unit\app\Http\Requests;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryRequest;
use Tests\TestCase;

class CategoryRequestTest extends TestCase
{
    /**
     * バリデーションのテスト
     *
     * @dataProvider validateDataProvider
     * @param string $name フォームの名前
     * @param string $value 想定入力値
     * @param boolean $result バリデート結果期待値 成功:true 失敗:false
     */
    public function testCategoryRequestValidate(string $name, string $value, bool $result)
    {
        $categoryRequest = new CategoryRequest;
        $rules = $categoryRequest->rules();
        $validator = Validator::make([$name => $value], $rules);
        $this->assertSame($result, $validator->passes());
    }

    /**
     *
     * @return array
     */
    public function validateDataProvider(): array
    {
        return [
            '正常値' => ['categoryName', 'カテゴリー1', true],
            '空文字' => ['categoryName', '', false],
            '文字数10文字以上' => ['categoryName', 'これはバリデーションテストです。', false]
        ];
    }
}
