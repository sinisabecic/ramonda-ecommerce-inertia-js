<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\UsersController;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Str;


//Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', [CartController::class, 'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}', [SaveForLaterController::class, 'switchToCart'])->name('saveForLater.switchToCart');

Route::post('/coupon', [CouponsController::class, 'store'])->name('coupon.store');
Route::delete('/coupon', [CouponsController::class, 'destroy'])->name('coupon.destroy');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/paypal-checkout', [CheckoutController::class, 'paypalCheckout'])->name('checkout.paypal');

Route::get('/guestCheckout', [CheckoutController::class, 'index'])->name('guestCheckout.index');


Route::get('/thankyou', [ConfirmationController::class, 'index'])->name('confirmation.index');


//Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::get('/search-algolia', [ShopController::class, 'searchAlgolia'])->name('search-algolia');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [UsersController::class, 'edit'])->name('ecommerce.users.edit');
    Route::patch('/my-profile', [UsersController::class, 'update'])->name('ecommerce.users.update');

    Route::get('/my-orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});





//? Stripe test routes
Route::get('/stripe/customers', function () {
    $stripe = Stripe::make(config('services.stripe.secret'));

    $customers = $stripe->customers()->all();

    foreach ($customers['data'] as $customer) {
        return $customer['email'];
    }
});
