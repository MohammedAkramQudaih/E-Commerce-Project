<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaymentsCallbackController;
use App\Http\Controllers\paymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{


Route::get('/',[SiteController::class,'index'])->name('website.index');
Route::get('/category/{id}',[SiteController::class,'category'])->name('website.category');
Route::get('product/{slug}',[SiteController::class,'product'])->name('website.product');
Route::get('cart/remove/{id}',[SiteController::class,'remove_item'])->name('website.remove_item');
Route::get('checkout',[SiteController::class,'checkout'])->name('website.checkout');
Route::post('payment',[SiteController::class,'payment'])->name('website.payment');
Route::post('product/buy',[SiteController::class,'buy'])->middleware('auth')->name('website.buy');
// Route::get('admin', function () {
//     return 'admin aria';
// })->middleware('auth','verified');


Route::prefix('admin')->name('admin.')->middleware(['auth','verified','isAdmin'])->group(function(){
    Route::get('',[DashboardController::class,'index']);

    Route::resource('categories',CategoryController::class);
    Route::resource('products',ProductController::class);
    Route::resource('discount',DiscountController::class);

});



// Route::get('user', function () {
//     return 'user aria';
// })->middleware('auth','verified');

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// routes/web.php


/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/




Route::get('payment/create',[paymentsController::class,'create'])->name('payment.create');
Route::get('payment/callback/success',[PaymentsCallbackController::class,'success'])->name('payment.success');
Route::get('payment/callback/cancel',[PaymentsCallbackController::class,'cancel'])->name('payment.cancel');

});