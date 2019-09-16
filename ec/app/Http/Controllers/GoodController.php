<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;

class GoodController extends Controller
{
    public function goodShow(Request $request)
    {
        $good = Good::find($request->good_id);
        return view('ec.goods.goodShow', ['good' => $good]);
    }
}
