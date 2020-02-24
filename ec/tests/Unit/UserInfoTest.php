<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\UserInfo;

class UserInfoTest extends TestCase
{
    use RefreshDatabase; //自動でマイグレーション実行

    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    /**
     * @test
     */
    public function edifUserInfo()
    {
        factory(UserInfo::class)->create(['name' => 'ishii']);

        $userInfo = new UserInfo;
        $testResult = $userInfo->editUserInfo([
            'user_id' => 1,
            'name' => 'テスト',
            'zip' => '100-0001',
            'address' => '東京都',
            'tel' => 0300000000
        ]);

        $this->assertDatabaseHas('user_infos',['name' => 'ishii']);
        $this->assertDatabaseHas('user_infos',['name' => 'テスト']);
    }

    /**
     * @test
     */
    public function getUserInfo()
    {
        factory(UserInfo::class)->create();

        $userInfo = new UserInfo;
        $result = $userInfo->getUserInfo(10);
        $this->assertDatabaseHas('user_infos', ['user_id' => 10]);
    }

    /**
     * @test
     */
    public function httpRequest()
    {
        $response = $this->get(route('top'));
        $response->assertStatus(200);
    }
}
