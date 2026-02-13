<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PaypalPaymentController; 
use App\Http\Controllers\Payment\StripePaymentController; 

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

// Route::get('/offline', 'HomeController@index')->name('offline');

Route::group(['prefix' => 'payment'], function () {

    Route::any('/{gateway}/pay', [PaymentController::class, 'payment_initialize']);

    // stripe
    Route::any('/stripe/create-session', [StripePaymentController::class, 'create_checkout_session'])->name('stripe.get_token');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');

    // paypal
    Route::get('/paypal/success', [PaypalPaymentController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaypalPaymentController::class, 'cancel'])->name('paypal.cancel');
  
});

Route::any('/social-login/redirect/{provider}', [LoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');


Route::get('/product/{slug}', [HomeController::class, 'index'])->name('product');
Route::get('/category/{slug}', [HomeController::class, 'index'])->name('products.category');

Route::get('/b/{slug}', [HomeController::class, 'index'])->name('blog.details');



//Address
Route::resource('addresses', AddressController::class);
Route::controller(AddressController::class)->group(function () {
    Route::post('/get-states', 'getStates')->name('get-state');
    Route::post('/get-cities', 'getCities')->name('get-city');
    Route::post('/addresses/update/{id}', 'update')->name('addresses.update');
    Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
    Route::get('/addresses/set_default/{id}', 'set_default')->name('addresses.set_default');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{slug}', [HomeController::class, 'index'])->where('slug', '.*');
