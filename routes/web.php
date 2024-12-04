<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Shop1\IndexController@showIndex');
Route::get('/good/detail', 'Shop1\IndexController@showGoodDetail');
Route::get('/good/cart', 'Shop1\IndexController@showGoodCart');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'Shop1\IndexController@showLogin');
    Route::post('/login', 'Shop1\IndexController@login')->middleware(['check_status']);
    Route::get('/register', 'Shop1\IndexController@showRegister');
    Route::post('/register', 'Shop1\IndexController@register');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['check_status'])->group(function () {
        Route::post('/good/addCart', 'Shop1\IndexController@goodAddCart');
        Route::post('/good/submit', 'Shop1\IndexController@goodSubmit');
        Route::post('/good/collect', 'Shop1\IndexController@goodCollect');
        Route::post('/good/like', 'Shop1\IndexController@goodLike');
        Route::post('/my/edit', 'Shop1\MyController@edit');
        Route::post('/my/pwd', 'Shop1\MyController@pwd');
        Route::post('/my/orderPay', 'Shop1\MyController@orderPay');
    });
    Route::get('/logout', 'Shop1\IndexController@logout');
    Route::get('/my/index', 'Shop1\MyController@showIndex');
    Route::get('/my/edit', 'Shop1\MyController@showEdit');
    Route::get('/my/pwd', 'Shop1\MyController@showPwd');
    Route::get('/my/collect', 'Shop1\MyController@showCollect');
    Route::get('/my/like', 'Shop1\MyController@showLike');
    Route::get('/my/order', 'Shop1\MyController@showOrder');
});

// Route::get('/zhuye','database\qimoController@zhuye');
// Route::get('/houtaifenye','database\moController@houtaifenye');
// Route::get('/qimologin','database\qimoController@qimologin');
// Route::get('/login','database\qimoController@login');
// Route::post('/yanzheng','database\qimoController@yanzheng');
// Route::get('/shopping','database\qimoController@shopping');
// Route::get('/shoppingcar','database\qimoController@shoppingcar');
// Route::get('/buy','database\qimoController@buy');
// Route::get('/collect','database\qimoController@collect');
// Route::get('/like','database\qimoController@like');
// Route::get('/exit','database\qimoController@exit');
// Route::get('/shopdetail','database\qimoController@shopdetail');
// Route::post('/insert','database\moController@insert');
// Route::get('/houtaidelete','database\qimoController@houtaidelete');
// Route::get('/houtaiupdate','database\qimoController@houtaiupdate');
// Route::post('/update','database\qimoController@update');
// Route::post('/store','database\qimoController@store');
// Route::get('/search','database\qimoController@search');
