<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Your protected routes go here
    /** Prdouct Routes */
    Route::get('/index', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

    Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');

    Route::post('/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');

    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');

    Route::put('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

    Route::delete('/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

    Route::post('/products/{product}/toggle-favorite', [App\Http\Controllers\ProductController::class, 'toggleFavorite'])->name('products.toggleFavorite');


    Route::get('/products/favorite-count', [App\Http\Controllers\ProductController::class, 'favoriteCount'])->name('products.favoriteCount');

    Route::get('/products/favorites', [ProductController::class, 'favorites'])
        ->name('products.favorites');
    /** End of Prdouct Routes */

    /** Cart Routes */
    Route::post('/cart/add/{productId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'totalQuantityInCart'])->name('cart.quantity');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'showCart'])->name('cart.show');

    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');

    Route::get('/cart/remove/{cartItemId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');

    // Route::get('/checkout',[App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    /** End of Cart Routes */

    /** Order Routes */
    // Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    // Route::get('/payment-page/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('payment.page');
    Route::get('/payment-page/{orderId}', [App\Http\Controllers\OrderController::class, 'show'])->name('payment.page');
    /** End of Order Routes */

    /** Checkout order Routes */
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    /** End of Checkout Order Routes */

    /** Favorites Routes */
    Route::post('/favorites/{favorite}/add-to-cart', [FavoriteController::class, 'addToCart'])->name('favorites.addToCart');
    Route::delete('/favorites/{favorite}/remove', [FavoriteController::class, 'removeFromFavorites'])->name('favorites.removeFromFavorites');
    /**End of Favorites Routes */
});
