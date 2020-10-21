<?php

namespace Tests\Unit\app\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MakerRequest;

class MakerRequestTest extends TestCase
{
    /**
     * バリデーションのテスト
     *
     * @dataProvider validateDataProvider
     * @param string $name フォームの名前
     * @param string $value 想定入力値
     * @param boolean $result バリデート結果期待値 成功:true 失敗:false
     */
    public function testMakerRequestValidate(string $name, string $value, bool $result)
    {
        $makerRequest = new MakerRequest;
        $rules = $makerRequest->rules();
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
            '正常値' => ['makerName', 'Panasonic', true],
            '空文字' => ['makerName', '', false],
            '文字数10文字以上' => ['makerName', 'United States of America', false]
        ];
    }
}
