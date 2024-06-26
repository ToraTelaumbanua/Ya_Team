<?php

use App\Http\Controllers\Auth\CartController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\CheckoutController;
use App\Http\Controllers\Auth\OrderController; // Tambahkan import ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/checkout/{id}', [ProductController::class, 'checkout'])->name('products.checkout');
});

// Rute untuk keranjang (hanya untuk pengguna yang terautentikasi)
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Tambahkan rute untuk checkout
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); // Pindahkan rute ini ke dalam grup middleware auth
});
