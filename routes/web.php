<?php


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/index', [ProductController::class, 'index'])
    ->name('products.index');

Route::prefix('cart')
    ->group(function () {
        Route::post('/cart', [CartController::class, 'store'])
            ->name('cart.store');

        Route::get('/', [CartController::class, 'index'])
            ->name('cart.index');

        Route::delete('/{product}', [CartController::class, 'destroy'])
            ->name('cart.destroy');

        Route::post('/', [CartController::class, 'sendEmail'])
            ->name('email.send');
    });
