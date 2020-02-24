<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Good;
use App\PurchaseHistory;

class PurchaseHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $PurchaseHistory;
    private $createArr;
    private $good;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(); // userテーブルを作成する

        $this->createArr = ['user_id' => $this->user->id, 'good_id' => $this->user->id, 'qty' => 3];
        $this->PurchaseHistory = factory(PurchaseHistory::class)->create($this->createArr); // purchaseHistoryテーブルの作成

        $this->good = factory(Good::class)->create(); // goodテーブルの作成
    }

    /**
     * @test
     */
    public function 購入履歴画面へアクセスすると302となる()
    {
        $response = $this->get(route('purchaseHistory'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function 購入履歴画面へアクセスするとログイン画面へリダイレクトする()
    {
        $response = $this->get(route('purchaseHistory'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function 購入履歴画面へログイン状態でアクセスすると200となる()
    {
        $response = $this->actingAs($this->user)->get(route('purchaseHistory'));; //ログイン済みにする
        $response = $this->get(route('purchaseHistory'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function 購入履歴画面へログイン状態でアクセスすると200となる_購入履歴なしの状態()
    {
        $this->PurchaseHistory = ''; //購入履歴を空にする
        $response = $this->actingAs($this->user)->get(route('purchaseHistory'));; //ログイン済みにする
        $response = $this->get(route('purchaseHistory'));
        $response->assertStatus(200);
    }
}
