<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseHistoryRankingController extends Controller
{
    private $purchaseHistory;

    public function __construct(\App\purchaseHistory $purchaseHistory)
    {
        $this->purchaseHistory = $purchaseHistory;
    }

    public function __invoke()
    {
        return json_encode($this->purchaseHistory->purchaseHistoryRanking());
    }
}
