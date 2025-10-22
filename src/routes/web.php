<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [ProductController::class, 'index'])->name('index');

//商品詳細画面
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product_show');

// 会員登録画面表示
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// ログイン画面
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// プロフィール設定画面表示
Route::get('/profile_setup', [ProfileController::class, 'setup'])->name('profile.setup');
Route::post('/profile_setup', [ProfileController::class, 'update'])->name('profile.update');

// メール認証誘導画面
Route::get('/verify-email', function () {
    return view('auth.verify');
})->name('verification.notice');

// 商品購入画面（仮）
Route::get('/purchase/{item_id}', function () {
    return view('products.purchase');
})->name('purchase');

// 送付先住所変更画面（仮）
Route::get('/purchase/address/{item_id}', function () {
    return view('mypage.address_edit');
})->name('address_edit');

// 検索結果（仮）
Route::get('/search', function () {
    $query = request('query');
    return view('search', ['query' => $query]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/sell', function () {
        return view('products.sell_form');
    })->name('sell.form');
    Route::post('/sell', [ProductController::class, 'store'])->name('sell.store');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('mypage.profile');
    Route::put('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile.edit');
});

// プロフィール編集画面（仮）
//Route::get('/mypage/profile', function () {
//    return view('mypage.profile_edit');
//})->name('mypage.profile.edit');


// プロフィール画面購入した商品一覧（仮）
//Route::get('/mypage?page=buy', function () {
//    return view('mypage.mypage');
//})->name('mypage.buy');

// プロフィール画面出品した商品一覧（仮）
//Route::get('/mypage?page=sell', function () {
//return view('mypage.mypage');
//})->name('mypage.sell');

//Route::get('/', function () {
//  return view('auth.login');
//});

// 商品一覧画面(トップページ)（仮）
//Route::get('/', function () {
//    return view('products.index');
//})->name('index');

//Route::get('/', function () {
//    $products = Product::all(); // 全商品を取得
//    return view('products.index', compact('products'));
//})->name('index');

// 商品詳細画面（仮）
//Route::get('/item/{item_id}', function () {
//    return view('products.product_show');
//})->name('product_show');

//Route::post('/profile_update', function () {
    // 仮の処理
//    return redirect()->route('profile_setup');
//})->name('profile.update');

// ログアウト（仮処理）
//Route::get('/logout', function () {
// 実際は Auth::logout() などを使う
//    return redirect('/')->with('message', 'ログアウトしました');
//})->name('logout');

// 商品出品画面（仮）
//Route::get('/sell', function () {
//    return view('products.sell_form');
//})->name('sell');

// プロフィール画面（仮）
//Route::get('/mypage', function () {
//    return view('mypage.mypage');
//})->name('mypage');

// 商品一覧画面(トップページ・マイリスト)（仮）
//Route::get('/?tab=mylist', function () {
//    return view('mylist');
//})->name('mylist');