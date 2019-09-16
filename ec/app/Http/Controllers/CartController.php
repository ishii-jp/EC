<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use Cart;

class CartController extends Controller
{
    public function cartConfirm(Request $request)
    {
        $post['good'] = Good::find($request->good_id);
        return view('ec.carts.cartConfirm', $post);
    }

    public function cartAdd(Request $request)
    {
        $post = [];
        if($request->action == 'add'){
            // $goods = Good::find($request->good_id);
            // $post['good_name'] = $goods->name;
            // $post['number'] = $request->number;
            // $post['good_id'] = $request->good_id;
            // // セッションにgood_idとnumberを保存する処理をここに書く
            // $value = ['good_id' => $post['good_id'], 'number' => $post['number']];
            // $request->session()->put('laravel_ec_cart'. $post['good_id'], $value);

            // Gloudemans\Shoppingcart\Shoppingcartを用いた実装
            $good = Good::find($request->good_id);
            Cart::add([
                [
                    'id' => $good->id,
                    'name' => $good->name,
                    'qty' => $request->number,
                    'price' => $good->price,
                    'weight' => '1',
                    // 'options' => ['photo_path'=> $book->photo_path]
                ]
            ]);
            $carts = Cart::content();
        } elseif('back'){
            return redirect(route('top'));
        }
        // return view('ec.carts.cartComplete', $post);
        return view('ec.carts.cartComplete', ['carts' => $carts]);
    }
}
