<?php

use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\OrderProductController;
use App\Http\Controllers\Back\ProductController as BackProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::prefix('cart')
    ->group(function () {
        Route::get('/', [CartController::class, 'index'])
            ->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])
            ->name('cart.store');
        Route::delete('/{product}', [CartController::class, 'destroy'])
            ->name('cart.destroy');
        Route::post('/', [CartController::class, 'sendEmail'])
            ->name('email.send');
    });
Route::prefix('backend')
    ->middleware('can:isAdmin')
    ->name('backend.')
    ->group(function () {
        Route::get('/products', [BackProductController::class, 'index'])
            ->name('products.index');
        Route::get('products/create', [BackProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products',[BackProductController::class, 'store'])
            ->name('products.store');
        Route::get('/products/{product}/edit', [BackProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [BackProductController::class, 'update'])
            ->name('products.update');
        Route::delete('/{product}', [BackProductController::class, 'destroy'])
            ->name('products.destroy');
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');
    });


