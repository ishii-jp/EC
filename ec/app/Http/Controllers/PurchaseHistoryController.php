<?php

namespace App\Http\Controllers;

use App\PurchaseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseHistoryController extends Controller
{
    private $purchaseHistory;

    /**
     * __construct
     *
     * @param PurchaseHistory $purchaseHistory
     */
    public function __construct(PurchaseHistory $purchaseHistory)
    {
        $this->purchaseHistory = $purchaseHistory;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $purchaseHistories = $this->purchaseHistory->getPurchaseHistory(Auth::id());
        return view('ec.purchaseHistorys.index')->with('purchaseHistories', $purchaseHistories);
    }
}
