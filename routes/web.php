<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('password/reset', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/faq',[IndexController::class, 'faq'])->name('faq');
Route::get('/contact',[IndexController::class, 'contact'])->name('contact');
Route::get('/about',[IndexController::class, 'about'])->name('about');

Route::get('/{user_id}/cart',[CartController::class, 'index'])->name('cart.index');

Route::name('categories.')->group(function () {
    Route::get('/categories/{category_slug}/', [CategoryController::class, 'show'])->name('show');
    Route::get('/category/{subcategory_slug}/', [CategoryController::class, 'subcategory'])->name('show.subcategory');
});;

Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::prefix('/products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{product_slug}', [ProductController::class, 'show'])->name('show');
    Route::post('/{id}/review-add', [ProductController::class, 'reviewAdd'])->name('review-add');
    Route::post('/{product:id}/add-to-cart', [CartController::class, 'store'])->name('add-to-cart');
    Route::post('/{product:slug}/delete-from-cart', [CartController::class, 'delete'])->name('delete-from-cart');
    Route::post('/{product_id}/buy-now', [CheckoutController::class, 'buyNow'])->name('buy-now');
    Route::post('/{products_id}/cart-to-checkout', [CheckoutController::class, 'cart_to_checkout'])->name('cart_to_checkout');
});

Route::prefix('/checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/store', [CheckoutController::class,'store'])->name('store');
});

Route::prefix('/order')->name('order.')->group(function () {
    Route::get('/create-user/{token}', [OrderController::class, 'index'])->name('index');
    Route::post('/create-user/{token}', [OrderController::class, 'store'])->name('store');
    Route::get('/add-address/{token}', [OrderController::class, 'addAddress'])->name('addAddress');
    Route::post('/add-address/{token}', [OrderController::class,'storeAddAddress'])->name('store.addAddress');
    Route::get('/confirmation/{token}', [OrderController::class, 'confirmation'])->name('confirmation');
});

Route::get('/profile/{id}', [UserController::class, 'index'])->name('profile.index');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');

Route::get('promotions', [PromotionsController::class, 'index'])->name('promotions.index');
Route::get('/promotions/{promotion_slug}', [PromotionsController::class, 'show'])->name('promotions.show');

Route::post('/create-paypal-payment', [PayPalController::class, 'createPayment'])->name('create.paypal.payment');
Route::get('/execute-paypal-payment', [PayPalController::class, 'executePayment'])->name('execute.paypal.payment');
Route::get('/cancel-paypal-payment', [PayPalController::class, 'cancelPayment'])->name('cancel.paypal.payment');

Route::fallback(function () {
    return view('404');
});
