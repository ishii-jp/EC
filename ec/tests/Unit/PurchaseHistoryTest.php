<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\PurchaseHistory;
use Illuminate\Support\Collection;
use App\Good;

class PurchaseHistoryTest extends TestCase
{
    use RefreshDatabase;

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
        $userId = 1;
        $createArr = ['user_id' => $userId, 'good_id' => 80, 'qty' => 3];
        factory(PurchaseHistory::class)->create($createArr);
        $purchaseHistory = new PurchaseHistory;
        $purchaseHistory->getPurchaseHistory($userId);

        $this->assertDatabaseHas('purchase_histories', $createArr);
    }

    /**
     * @test
     */
    public function purchaseHistoryRanking_該当するcategoryIdがない場合空のコレクションを返すること()
    {
        $ret = PurchaseHistory::purchaseHistoryRanking();
        $this->assertTrue($ret->isEmpty());
    }

    /**
     * @test
     */
    public function purchaseHistoryRanking_商品ランキングを返すこと()
    {
        // purchaseHistoriewテーブルテストデータ作成
        $rankFirstId = 8;
        $rankSecondId = 9;
        $rankThirdId = 10;
        $rankFourthId = 11;
        $rankFirstCount = 40;
        $rankSecondCount = 30;
        $rankThirdCount = 20;
        $rankFourthCount = 10;
        factory(PurchaseHistory::class, $rankFourthCount)->create(['good_id' => $rankFourthId]);
        factory(PurchaseHistory::class, $rankThirdCount)->create(['good_id' => $rankThirdId]);
        factory(PurchaseHistory::class, $rankSecondCount)->create(['good_id' => $rankSecondId]);
        factory(PurchaseHistory::class, $rankFirstCount)->create(['good_id' => $rankFirstId]);

        $ret = PurchaseHistory::purchaseHistoryRanking();

        // ランキング順位の検証をします。
        foreach ($ret->toArray() as $key => $value) {
            if ($key === 0) {
                // 1位
                $this->assertSame($rankFirstId, $value['good_id']);
                $this->assertSame($rankFirstCount, $value['purchase_history_count']);
            }
            if ($key === 1) {
                // 2位
                $this->assertSame($rankSecondId, $value['good_id']);
                $this->assertSame($rankSecondCount, $value['purchase_history_count']);
            }
            if ($key === 2) {
                // 3位
                $this->assertSame($rankThirdId, $value['good_id']);
                $this->assertSame($rankThirdCount, $value['purchase_history_count']);
            }
            if ($key === 3) {
                // 4位
                $this->assertSame($rankFourthId, $value['good_id']);
                $this->assertSame($rankFourthCount, $value['purchase_history_count']);
            }
        }
    }

    /**
     * @test
     */
    public function purchaseHistoryRankingByCategory_categoryIdがnullの場合は空のコレクションを返すこと()
    {
        $categoryId = null;
        $this->assertEquals(new Collection, PurchaseHistory::purchaseHistoryRankingByCategory($categoryId));
    }

    /**
     * @test
     */
    public function purchaseHistoryRankingByCategory_該当するcategoryIdがない場合空のコレクションを返すること()
    {
        $categoryId = '1';
        $ret = PurchaseHistory::purchaseHistoryRankingByCategory($categoryId);
        $this->assertTrue($ret->isEmpty());
    }

    /**
     * @test
     */
    public function purchaseHistoryRankingByCategory_categoryIdごとの商品ランキングを返すこと()
    {
        $categoryId = '1';
        // goodsテーブルテストデータ作成
        factory(Good::class, 10)->create(['category_id' => $categoryId]);
        factory(Good::class, 10)->create(['category_id' => $categoryId + '1']);

        // purchaseHistoriewテーブルテストデータ作成
        $rankFirstId = 8;
        $rankSecondId = 9;
        $rankThirdId = 10;
        $notRankId = 11;
        $rankFirstCount = 35;
        $rankSecondCount = 20;
        $rankThirdCount = 10;
        factory(PurchaseHistory::class, $rankThirdCount)->create(['good_id' => $rankThirdId]);
        factory(PurchaseHistory::class, $rankSecondCount)->create(['good_id' => $rankSecondId]);
        factory(PurchaseHistory::class, 30)->create(['good_id' => $notRankId]);
        factory(PurchaseHistory::class, $rankFirstCount)->create(['good_id' => $rankFirstId]);

        $ret = PurchaseHistory::purchaseHistoryRankingByCategory($categoryId);

        // ランキング順位の検証をします。
        foreach ($ret->toArray() as $key => $value) {
            if ($key === 0) {
                // 1位
                $this->assertSame($rankFirstId, $value['good_id']);
                $this->assertSame($rankFirstCount, $value['purchase_history_count']);
            }
            if ($key === 1) {
                // 2位
                $this->assertSame($rankSecondId, $value['good_id']);
                $this->assertSame($rankSecondCount, $value['purchase_history_count']);
            }
            if ($key === 2) {
                // 3位
                $this->assertSame($rankThirdId, $value['good_id']);
                $this->assertSame($rankThirdCount, $value['purchase_history_count']);
            }
            // good_id 11 はcategoryIdが条件に合致しないため含まれていないこと
            $this->assertNotSame($notRankId, $value['good_id']);
        }
    }
}
