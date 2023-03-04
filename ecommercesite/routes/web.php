<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//auth loging and restion
Route::get('/redirect',[HomeController::class,'redirect'])->middleware('auth','verified');
//home
Route::get('/',[HomeController::class,'index']);
Route::get('/product_details/{id}',[HomeController::class,'product_details']);
Route::post('/add_card/{id}',[HomeController::class,'add_card']);
Route::get('/show_cart',[HomeController::class,'show_cart']);
Route::get('/remove_card/{id}',[HomeController::class,'remove_card']);
//cash on delivery
Route::get('/cash_order',[HomeController::class,'cash_order']);
Route::get('/stripe/{totalprice}',[HomeController::class,'stripe']);
 //paid section
Route::post('stripe/{totalprice}', [HomeController::class,'stripePost'])->name('stripe.post');
// end paid section
Route::get('/show_order',[HomeController::class,'show_order']);
Route::get('/cencle_order/{id}',[HomeController::class,'cencle_order']);
Route::post('/add_comment',[HomeController::class,'add_comment']);
Route::post('/add_reply',[HomeController::class,'add_reply']);
Route::get('/product_search',[HomeController::class,'product_search']);
Route::get('/all_product',[HomeController::class,'all_product']);
//all product search jono
Route::get('/search_product',[HomeController::class,'search_product']);

//admin
Route::get('/view_catagory',[AdminController::class,'view_catagory']);
Route::post('/add_catagory',[AdminController::class,'add_catagory']);
Route::get('/delete_catagory/{id}',[AdminController::class,'delete_catagory']);
Route::get('/view_product',[AdminController::class,'view_product']);
Route::post('/add_product',[AdminController::class,'add_product']);
Route::get('/show_product',[AdminController::class,'show_product']);
Route::get('/delete_product/{id}',[AdminController::class,'delete_product']);
Route::get('/update_product/{id}',[AdminController::class,'update_product']);
Route::post('/update_product_confirm/{id}',[AdminController::class,'update_product_confirm']);
Route::get('/order',[AdminController::class,'order']);
Route::get('/delivered/{id}',[AdminController::class,'delivered']);
Route::get('/print_pdf/{id}',[AdminController::class,'print_pdf']);
Route::get('/send_email/{id}',[AdminController::class,'send_email']);
Route::post('/send_user_email/{id}',[AdminController::class,'send_user_email']);
Route::get('/search',[AdminController::class,'searchdata']);