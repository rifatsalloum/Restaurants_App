<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;

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
Route::post("login",[UserController::class,"login"]);
Route::post("register",[UserController::class,"store"]);

Route::get("restaurant/all",[RestaurantController::class,"index"]);
Route::post("restaurant/search",[RestaurantController::class,"search"]);

Route::group(["middleware" => ["user-auth"]],function () {

    Route::post("restaurant/rate",[RatingController::class,"store"]);

    Route::get("order/all",[OrderController::class,"index"]);
    Route::post("order/place", [OrderController::class, "store"]);
    Route::post("order/change/status",[OrderController::class,"makeOrderTaked"]);
    Route::post("order/new/prices",[OrderController::class,"newPricesOrder"]);
    Route::post("reorder",[OrderController::class,"update"]);
    Route::post("order/delete",[OrderController::class,"destroy"]);


    Route::get("logout",[UserController::class,"logout"]);

});

