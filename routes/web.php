<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\InvoiceController;
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
    Route::resource('partners', PartnerController::class)
        ->only(['index', 'create', 'store', 'show']);

    // 受注管理（一覧・登録など必要なアクションのみ）
    Route::resource('sales_orders', SalesOrderController::class)
        ->only(['index', 'create', 'store', 'show']);

    // 請求書管理（一覧・詳細のみ）
    Route::resource('invoices', InvoiceController::class)
        ->only(['index', 'show']);

    // 請求書発行（受注詳細画面から遷移）
    Route::get('/sales_orders/{order}/invoices/create', [InvoiceController::class, 'create'])
        ->name('invoices.create');
    
    Route::post('/sales_orders/{order}/invoices', [InvoiceController::class, 'store'])
        ->name('invoices.store');

    Route::resource('invoices', InvoiceController::class)
        ->only(['index', 'create', 'store', 'show']);
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
