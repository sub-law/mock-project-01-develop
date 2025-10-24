<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\FavoriteController;
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

Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product_show');

Route::post('/favorite/toggle', [FavoriteController::class, 'toggle'])->middleware('auth');

Route::post('/comments', [ProductController::class, 'storeComment'])->name('comments.store');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile_setup', [ProfileController::class, 'setup'])->name('profile.setup');
Route::post('/profile_setup', [ProfileController::class, 'update'])->name('profile.update');

// メール認証誘導画面未実装
Route::get('/verify-email', function () {
    return view('auth.verify');
})->name('verification.notice');

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

    // 出品関連
    Route::get('/sell', function () {
        return view('products.sell_form');
    })->name('sell.form');

    Route::post('/sell', [ProductController::class, 'store'])->name('sell.store');

    // 購入画面表示
    Route::get('/purchase/{item_id}', [ProductController::class, 'showPurchaseForm'])->name('purchase');

    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->name('address_edit');
    Route::put('/purchase/address/{item_id}', [AddressController::class, 'update'])->name('address_update');

    // マイページ関連
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/mypage/profile', 'profile')->name('mypage.profile');
        Route::put('/mypage/profile', 'edit')->name('mypage.profile.edit');
    });
});
