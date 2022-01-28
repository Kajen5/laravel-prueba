<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\orders_detailController;
use App\Http\Controllers\otrosController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
    Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
    Route::get('signout', [CustomAuthController::class, 'signOut'])->middleware('auth:sanctum');
    Route::get('ShowUserlist', [CustomAuthController::class, 'ShowUserlist'])->name('showuserlist');


});
Route::controller(ordersController::class)->group(function () {
    Route::get('orders', 'index');
    Route::post('/orders', 'store');
    Route::delete('orders/{id}', 'delete');
    Route::put('orders/{id}', 'update');
});
Route::middleware(['auth:sanctum'])->group(function () {

    
    Route::controller(orders_detailController::class)->group(function () {
        Route::get('orders_detail', 'index');
        Route::post('orders_detail', 'store');
        Route::delete('orders_detail/{id}', 'delete');
        Route::put('orders_detail/{id}', 'update');
    });
    Route::controller(otrosController::class)->group(function () {
        Route::get('otros', 'index');
        Route::post('otros', 'store');
    });
});