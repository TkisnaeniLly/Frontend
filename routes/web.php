<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', function () {
//     // return view('welcome');
//     return view('pages.home');
// });

use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocaleController;

Route::get('/lang/{locale}', [LocaleController::class, 'setLocale'])->name('locale.switch');

// Product Routes
// Product Routes - Protected
Route::middleware([\App\Http\Middleware\CheckAuth::class])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');
});

// Cart Routes
Route::get('/keranjang', function () {
    return view('pages.cart');
});
Route::get('/cart', function () {
    return view('pages.cart');
});

Route::get('/checkout', function () {
    return view('pages.checkout');
});

Route::get('/wishlist', function () {
    return view('pages.wishlist');
})->name('wishlist');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;

Route::get('/login', function () {
    if (Session::has('user') || Session::has('api_token')) {
        return redirect('/');
    }
    return view('pages.login');
})->name('login');

Route::get('/register', function () {
    if (Session::has('user') || Session::has('api_token')) {
        return redirect('/');
    }
    return view('pages.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/auth/user', [AuthController::class, 'user']);

use App\Http\Controllers\CartController;

Route::get('/cart/data', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::put('/cart', [CartController::class, 'update']);
Route::delete('/cart', [CartController::class, 'destroy']);