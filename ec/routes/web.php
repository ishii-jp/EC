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

Route::match(['get', 'post'], '/', 'PageController@top')->name('top');
Route::get('/show', 'PageController@show')->name('show');

// カート機能
Route::group(['prefix' => 'cart'], function() {
    Route::get('/', 'CartController@cartShow')->name('cartShow');
    Route::delete('delete', 'CartController@cartDelete')->name('cartDelete');
    Route::delete('reset', 'CartController@cartReset')->name('cartReset');
    Route::post('confirm', 'CartController@cartConfirm')->name('cartConfirm');
    Route::post('add', 'CartController@cartAdd')->name('cartAdd');
});

// 決済機能
Route::group(['prefix' => 'pay'], function() {
    Route::get('/', 'PaymentController@index')->name('payIndex');
    Route::post('/', 'PaymentController@pay')->name('pay');
    Route::match(['get', 'post'], 'userInfo', 'PaymentController@registUserInfo')->name('payRegistUserInfo');
    Route::post('userInfo/confirm', 'PaymentController@postRegistUserInfo')->name('payPostRegistUserInfo');
});

// 商品詳細画面
Route::group(['prefix' => 'good'], function() {
    Route::middleware('auth:admin')->group(function (){
        Route::get('index', 'GoodController@goodIndex')->name('goodIndex');
        Route::get('add', 'GoodController@goodAdd')->name('goodAdd');
        Route::post('create', 'GoodController@goodCreate')->name('goodCreate');
        Route::post('update', 'GoodController@goodUpdate')->name('goodUpdate');
    });
    Route::get('{good_id}', 'GoodController@goodShow')->name('goodShow');
});

// 商品検索
Route::match(['get','post'],'goodsSeatch', 'GoodsSearchController')->name('goodsSearch');

// 商品カテゴリー機能
Route::get('/category', 'CategoryController@categoryIndex')->name('categoryIndex');
Route::get('/category/{category_id}', 'CategoryController@categoryShow')->name('categoryShow');

Auth::routes();

// User 認証不要

// User ログイン後
Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    // マイページ
    Route::group(['prefix' => 'mypage'], function() {
        Route::get('/', 'MyPageController@index')->name('myPage');
        Route::match(['get', 'post'], 'edit', 'MyPageController@edit')->name('myPageAdd');
    });
    // 購入履歴機能
    Route::get('/purchaseHistory','purchaseHistoryController')->name('purchaseHistory');
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

// Route::get('/home', 'HomeController@index')->name('home');

// OAuth認証
// facebook
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');