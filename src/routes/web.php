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

//Route::get('/', function () {
//  return view('auth.login');
//});

// ログイン画面表示
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 会員登録画面表示
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// メール認証誘導画面
Route::get('/verify-email', function () {
    return view('auth.verify');
})->name('verification.notice');
