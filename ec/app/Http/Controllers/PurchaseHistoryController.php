<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseHistoryController extends Controller
{
    private $purchaseHistory;

    public function __construct(\App\purchaseHistory $purchaseHistory)
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
        if (Auth::check()){
            $purchaseHistories = $this->purchaseHistory->getPurchaseHistory(Auth::id());
        } else {
            throw new Exception('ログインしていません');
        }
        return view('ec.purchaseHistorys.index')->with('purchaseHistories', $purchaseHistories);
    }
}
