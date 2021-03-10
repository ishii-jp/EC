<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\PurchaseHistory;
use Illuminate\Support\Collection;

class PurchaseHistoryTest extends TestCase
{
    use RefreshDatabase;

    private $userId;
    private $createArr;

    public function setUp(): void
    {
        parent::setUp();

        $this->userId = 1;
        $this->createArr = ['user_id' => $this->userId, 'good_id' => 80, 'qty' => 3];
        factory(PurchaseHistory::class)->create($this->createArr);
    }

    /**
     * @test
     */
    public function registPurchaseHistory_普通に登録ができること()
    {
        $purchaseHistory = new PurchaseHistory;
        $item = ['id' => 80, 'qty' => 1];
        $userId = 1;
        $purchaseHistory->registPurchaseHistory($item, $userId);

        $this->assertDatabaseHas('purchase_histories', ['user_id' => $userId, 'good_id' => $item['id'], 'qty' => $item['qty']]);
    }

    /**
     * @test
     */
    public function getPurchaseHistory_setUpにて作成した購入履歴を取得できること()
    {
        $purchaseHistory = new PurchaseHistory;
        $purchaseHistory->getPurchaseHistory($this->userId);

        $this->assertDatabaseHas('purchase_histories', $this->createArr);
    }

    // TODO DB purchese_historiesにcategory_idカラムを追加したらpurchaseHistoryRankingByCategoryをテストする

    /**
     * @test
     */
    public function purchaseHistoryRankingByCategory_categoryIdがnullの場合は空のコレクションを返すこと()
    {
        $categoryId = null;
        $this->assertEquals(new Collection, PurchaseHistory::purchaseHistoryRankingByCategory($categoryId));
    }
}
