<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップ画面
Route::match(['get', 'post'], '/', 'PageController@top')->name('top');

// 商品一覧画面
Route::get('/show', 'PageController@show')->name('show');

// カート機能
Route::group(['prefix' => 'cart'], function() {
    Route::get('/', 'CartController@cartShow')->name('cart');
    Route::delete('delete', 'CartController@cartDelete')->name('cart.delete');
    Route::delete('reset', 'CartController@cartReset')->name('cart.reset');
    Route::post('confirm', 'CartController@cartConfirm')->name('cart.confirm');
    Route::post('add', 'CartController@cartAdd')->name('cart.add');
});

// 決済機能
Route::group(['prefix' => 'pay'], function() {
    Route::match(['get', 'post'], '/', 'PaymentController@index')->name('pay');
    Route::match(['get', 'post'], 'userInfo', 'PaymentController@registUserInfo')->name('pay.userInfo');
    Route::post('userInfo/confirm', 'PaymentController@postRegistUserInfo')->name('pay.useInfo.confirm');
});

// 商品詳細画面(管理者機能)
Route::group(['prefix' => 'good'], function() {
    Route::middleware('auth:admin')->group(function (){
        Route::get('index', 'GoodController@goodIndex')->name('good.index');
        Route::get('add', 'GoodController@goodAdd')->name('good.add');
        Route::post('create', 'GoodController@goodCreate')->name('good.create');
        Route::post('update', 'GoodController@goodUpdate')->name('good.update');
    });
    Route::get('{good_id}', 'GoodController@goodShow')->name('good.good_id');
});

// 商品検索機能
Route::match(['get','post'],'goodsSeatch', 'GoodsSearchController')->name('goodsSearch');

// 商品カテゴリー機能
Route::group(['prefix' => 'category'], function() {
    Route::get('', 'CategoryController@categoryIndex')->name('category');
    // 管理者機能
    Route::middleware('auth:admin')->group(function (){
        Route::get('add', 'CategoryController@categoryAdd')->name('category.add');
        Route::post('add/post', 'CategoryController@categoryAddPost')->name('category.add.post');
    });
    Route::get('{category_id}', 'CategoryController@categoryShow')->name('category.category_id');
});

// メーカー機能
Route::group(['prefix' => 'maker'], function() {
    // 管理者機能
    Route::middleware('auth:admin')->group(function (){
        Route::get('add', 'MakerController@makerAdd')->name('maker.add');
        Route::post('add/post', 'MakerController@makerAddPost')->name('maker.add.post');
    });
});

Auth::routes();

// User 認証不要

// User ログイン後
Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    // マイページ機能
    Route::group(['prefix' => 'myPage'], function() {
        Route::get('/', 'MyPageController@index')->name('myPage');
        Route::match(['get', 'post'], 'edit', 'MyPageController@edit')->name('myPage.edit');
    });
    // 購入履歴機能
    Route::get('/purchaseHistory','PurchaseHistoryController')->name('purchaseHistory');
});

// Admin 認証不要
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',         function () { return redirect('/admin/home'); });
    Route::get('login',     'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'Admin\LoginController@login');
});

// Admin ログイン後
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::post('logout',   'Admin\LoginController@logout')->name('admin.logout');
    Route::get('home',      'Admin\HomeController@index')->name('admin.home');
});

// OAuth認証
// facebook
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');