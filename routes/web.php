<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Support\Storage\Contracts\StorageInterface;

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products', 'ProductController@index')->name('products.index');

Route::get('/basket/add/{product}', 'BasketController@add')->name('basket.add');
Route::get('basket', 'BasketController@index')->name('basket.index');
Route::post('basket/update/{product}', 'BasketController@update')->name('basket.update');
Route::get('basket/checkout', 'BasketController@checkoutForm')->name('basket.checkout.form');
Route::post('basket/checkout', 'BasketController@checkout')->name('basket.checkout');

Route::post('payment/{gateway}/callback', 'PaymentController@verify')->name('payment.verify');

Route::post('coupon', 'CouponController@store')->name('coupons.store');
Route::get('coupon', 'CouponController@remove')->name('coupons.remove');

Route::get('orders', 'OrderController@index')->name('orders');
Route::get('invoice/{order}', 'InvoiceController@show')->name('invoice.show');
Route::get('orders/pay/{order}', 'OrderController@pay')->name('order.pay');


Route::get('basket/clear', function () {
    resolve(StorageInterface::class)->clear();
});
