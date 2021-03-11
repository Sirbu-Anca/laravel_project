<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Back\OrderController;
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

Route::get('/getProducts',[ ProductController::class, 'getProducts'])
    ->name('products.get');

Route::prefix('cart')
    ->group(function () {
        Route::get('/', [CartController::class, 'index'])
            ->name('cart.index');
        Route::get('/', [CartController::class, 'displayCartProducts'])
            ->name('cart.show');
        Route::post('/cart', [CartController::class, 'store'])
            ->name('cart.store');
        Route::delete('/{product}', [CartController::class, 'destroy'])
            ->name('cart.destroy');
        Route::post('/', [CartController::class, 'sendEmail'])
            ->name('email.send');
    });

Route::prefix('backend')
    ->name('backend.')
    ->group(function () {
        Route::resource('products', BackProductController::class);
        Route::resource('orders', OrderController::class)->only([
            'index', 'show'
        ]);
    });
