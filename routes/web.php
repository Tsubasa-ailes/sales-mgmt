<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes（誰でもアクセス可）
|--------------------------------------------------------------------------
*/

// ホーム（ダッシュボード風トップ画面）
Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Authenticated Routes（ログイン必須）
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // ダッシュボード（Jetstream/Breeze 標準）
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // マスタ系（商品・取引先）
    Route::resource('products', ProductController::class);
    Route::resource('partners', PartnerController::class);

    // 受注管理（一覧・登録など必要なアクションのみ）
    Route::resource('sales_orders', SalesOrderController::class)
        ->only(['index', 'create', 'store']);
});


/*
|--------------------------------------------------------------------------
| Admin-only Routes（管理者専用）
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // ユーザー管理（一覧・登録）
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
});


/*
|--------------------------------------------------------------------------
| Auth scaffolding (login / register / password reset ...)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
