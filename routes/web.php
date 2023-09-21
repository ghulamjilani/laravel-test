<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\web\{
    UserController,
    ProductController,
    OrderController
};

use App\Http\Controllers\{
    StripePaymentController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/checkout', [StripePaymentController::class, 'checkout'])->name('checkout');
Route::post('/session', [StripePaymentController::class, 'session'])->name('session');
Route::get('/success', [StripePaymentController::class, 'success'])->name('success');

Route::middleware(['auth:sanctum'])->group(function () {
    
    // products route
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.list');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
    });

    // orders route
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'index'])->name('order');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
    });
});