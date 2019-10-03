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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::match(['get', 'post'], '/', 'PageController@top')->name('top');
Route::get('/show', 'PageController@show')->name('show');

// カート機能
Route::get('/cart', 'CartController@cartShow')->name('cartShow');
Route::delete('/cart/delete', 'CartController@cartDelete')->name('cartDelete');
Route::delete('/cart/reset', 'CartController@cartReset')->name('cartReset');
Route::post('/cart/confirm', 'CartController@cartConfirm')->name('cartConfirm');
Route::post('/cart/add', 'CartController@cartAdd')->name('cartAdd');

// 決済機能
Route::get('/pay', 'PaymentController@index')->name('payIndex');
Route::post('/pay', 'PaymentController@pay')->name('pay');

// 商品詳細画面
Route::group(['prefix' => 'good'], function() {
    Route::get('index', 'GoodController@goodIndex')->name('goodIndex');
    Route::get('add', 'GoodController@goodAdd')->name('goodAdd');
    Route::post('update', 'GoodController@goodUpdate')->name('goodUpdate');
    Route::get('{good_id}', 'GoodController@goodShow')->name('goodShow');
});

// 商品カテゴリー機能
Route::get('/category', 'CategoryController@categoryIndex')->name('categoryIndex');
Route::get('/category/{category_id}', 'CategoryController@categoryShow')->name('categoryShow');

Auth::routes();

/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
// Route::get('/', function () { return redirect('/home'); });
 
/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
});

/*
|--------------------------------------------------------------------------
| 3) Admin 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',         function () { return redirect('/admin/home'); });
    Route::get('login',     'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'Admin\LoginController@login');
});
 
/*
|--------------------------------------------------------------------------
| 4) Admin ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::post('logout',   'Admin\LoginController@logout')->name('admin.logout');
    Route::get('home',      'Admin\HomeController@index')->name('admin.home');
});

// Route::get('/home', 'HomeController@index')->name('home');

// OAuth認証
// facebook
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');