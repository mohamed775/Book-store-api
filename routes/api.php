<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAuth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
define('PAGINATION_COUNTER',5);

    //admin
Route::post('admin/login', [App\Http\Controllers\API\Admin\AuthAdminController::class, 'login']);

Route::middleware('AdminAuth')->group(function(){
    
    Route::get('category/index', [App\Http\Controllers\API\Admin\CategoryController::class, 'index']);
    Route::get('category/show/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'showBooks']);
    Route::post('category/update/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'update']);
    Route::post('category/delete/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'delete']);
    Route::post('category/store', [App\Http\Controllers\API\Admin\CategoryController::class, 'store']);
    
    Route::get('book/index', [App\Http\Controllers\API\Admin\BookController::class, 'index']);
    Route::post('book/store', [App\Http\Controllers\API\Admin\BookController::class, 'store']);
    Route::post('book/update/{id}', [App\Http\Controllers\API\Admin\BookController::class, 'update']);
    Route::post('book/delete/{id}', [App\Http\Controllers\API\Admin\BookController::class, 'delete']);
    
    Route::get('user/index', [App\Http\Controllers\API\Admin\UserController::class, 'index']);
    Route::get('user/delete/{id}', [App\Http\Controllers\API\Admin\UserController::class, 'delete']);    
});

    //user
Route::post('user/register', [App\Http\Controllers\API\User\AuthUserController::class, 'register']);
Route::post('user/login', [App\Http\Controllers\API\User\AuthUserController::class, 'login']);

Route::middleware('UserAuth')->group(function(){
    Route::get('books', [App\Http\Controllers\API\User\HomeController::class, 'allBooks']);
    Route::get('books/{id}', [App\Http\Controllers\API\User\HomeController::class, 'books']);
    Route::get('search', [App\Http\Controllers\API\User\HomeController::class, 'search']);
    Route::post('cart/store', [App\Http\Controllers\API\User\CartController::class, 'store']);
    Route::get('cart/show', [App\Http\Controllers\API\User\CartController::class, 'showCart']);
    Route::post('cart/cancel/{id}', [App\Http\Controllers\API\User\CartController::class, 'delete']);
    Route::get('checkout',[App\Http\Controllers\API\User\PaymentController::class,'buy']);
    Route::get('storeTransaction',[App\Http\Controllers\API\User\PaymentController::class,'storeTransaction']);
});

