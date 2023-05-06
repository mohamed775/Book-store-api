<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('admin/login', [App\Http\Controllers\API\Admin\AuthAdminController::class, 'login']);

Route::get('category/index', [App\Http\Controllers\API\Admin\CategoryController::class, 'index']);
Route::get('category/show/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'show']);
Route::post('category/store', [App\Http\Controllers\API\Admin\CategoryController::class, 'store']);
Route::post('category/update/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'update']);
Route::post('category/delete/{id}', [App\Http\Controllers\API\Admin\CategoryController::class, 'delete']);

Route::get('book/index', [App\Http\Controllers\API\Admin\BookController::class, 'index']);
Route::post('book/store', [App\Http\Controllers\API\Admin\BookController::class, 'store']);
Route::post('book/update/{id}', [App\Http\Controllers\API\Admin\BookController::class, 'update']);
Route::post('book/delete/{id}', [App\Http\Controllers\API\Admin\BookController::class, 'delete']);

Route::get('user/index', [App\Http\Controllers\API\Admin\UserController::class, 'index']);
Route::get('user/delete/{id}', [App\Http\Controllers\API\Admin\UserController::class, 'delete']);


    //user
Route::post('user/register', [App\Http\Controllers\API\User\AuthUserController::class, 'register']);
Route::post('user/login', [App\Http\Controllers\API\User\AuthUserController::class, 'login']);

Route::get('books', [App\Http\Controllers\API\User\HomeController::class, 'allBooks']);
Route::get('books/{id}', [App\Http\Controllers\API\User\HomeController::class, 'books']);
Route::get('search', [App\Http\Controllers\API\User\HomeController::class, 'search']);
