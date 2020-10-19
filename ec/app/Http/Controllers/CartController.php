<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use Cart;

class CartController extends Controller
{
    public function cartShow()
    {
        return view('ec.carts.cartShow');
    }

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
            $results = Cart::add([
                [
                    'id' => $good->id,
                    'name' => $good->name,
                    'qty' => $request->number,
                    'price' => $good->price,
                    'weight' => '1',
                    // 'options' => ['photo_path'=> $book->photo_path]
                ]
            ]);
            // $carts = Cart::content();
            foreach ($results as $result) $carts[] = Cart::get($result->rowId);
        } elseif('back'){
            return redirect(route('show'));
        }
        // return view('ec.carts.cartComplete', $post);
        return view('ec.carts.cartComplete', ['carts' => $carts]);
    }

    public function cartReset()
    {
        Cart::destroy();
        return redirect(route('cart'));
    }

    public function cartDelete(Request $request)
    {
        Cart::remove($request->rowId);
        return redirect(route('cart'));
    }
}
