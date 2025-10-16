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

// 商品一覧画面(トップページ)（仮）
Route::get('/', function () {
    return view('products.index');
})->name('index');

// 商品一覧画面(トップページ・マイリスト)（仮）
Route::get('/?tab=mylist', function () {
    return view('mylist');
})->name('mylist');

// 会員登録画面表示
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// プロフィール設定画面表示
Route::get('/profile_setup', function () {
    return view('auth.profile_setup');
})->name('profile_setup');

Route::post('/profile_update', function () {
    // 仮の処理
    return redirect()->route('profile_setup');
})->name('profile.update');

// ログイン画面表示
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// メール認証誘導画面
Route::get('/verify-email', function () {
    return view('auth.verify');
})->name('verification.notice');

// ログアウト（仮処理）
Route::get('/logout', function () {
    // 実際は Auth::logout() などを使う
    return redirect('/')->with('message', 'ログアウトしました');
})->name('logout');

// 商品詳細画面（仮）
Route::get('/item/{item_id}', function () {
    return view('products.product_show');
})->name('product_show');

// 商品購入画面（仮）
Route::get('/purchase/{item_id}', function () {
    return view('products.purchase');
})->name('purchase');

// 送付先住所変更画面（仮）
Route::get('/purchase/address/{item_id}', function () {
    return view('mypage.address_edit');
})->name('address_edit');

// 商品出品画面（仮）
Route::get('/sell', function () {
    return view('products.sell_form');
})->name('sell');

// 検索結果（仮）
Route::get('/search', function () {
    $query = request('query');
    return view('search', ['query' => $query]);
});

// プロフィール画面（仮）
Route::get('/mypage', function () {
    return view('mypage.mypage');
})->name('mypage');

// プロフィール編集画面（仮）
Route::get('/mypage/profile_edit', function () {
    return view('mypage.profile_edit');
})->name('mypage.profile_edit');

// プロフィール画面購入した商品一覧（仮）
Route::get('/mypage?page=buy', function () {
    return view('mypage.mypage');
})->name('mypage.buy');

// プロフィール画面出品した商品一覧（仮）
Route::get('/mypage?page=sell', function () {
    return view('mypage.mypage');
})->name('mypage.sell');
