<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest_admin'])->group(function () {
    Route::get('/admin/login', 'Admin1\IndexController@showLogin');
    Route::post('/admin/login', 'Admin1\IndexController@login');
});

Route::middleware(['auth_admin'])->group(function () {
    Route::get('/admin/index', 'Admin1\IndexController@showIndex');
    Route::get('/admin/logout', 'Admin1\IndexController@logout');
    Route::get('/admin/pwd', 'Admin1\IndexController@showPwd');
    Route::post('/admin/pwd', 'Admin1\IndexController@pwd');
    Route::get('/admin/theme', 'Admin1\IndexController@showTheme');
    Route::post('/admin/theme', 'Admin1\IndexController@theme');
    Route::get('/admin/good', 'Admin1\GoodController@showGoodIndex');
    Route::get('/admin/goodEdit', 'Admin1\GoodController@showGoodEdit');
    Route::post('/admin/goodEdit', 'Admin1\GoodController@goodEdit');
    Route::post('/admin/goodDel', 'Admin1\GoodController@goodDel');
    Route::post('/admin/goodPic', 'Admin1\GoodController@goodPic');
    Route::get('/admin/order', 'Admin1\OrderController@showIndex');
    Route::post('/admin/orderDel', 'Admin1\OrderController@orderDel');
    Route::get('/admin/user', 'Admin1\UserController@showIndex');
    Route::post('/admin/userPwd', 'Admin1\UserController@userPwd');
    Route::post('/admin/userDeny', 'Admin1\UserController@userDeny');
});
