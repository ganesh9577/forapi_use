<?php

use App\Http\Controllers\Api\LoginApicontroller;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\VendorApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//all game display
Route::get('games',[GameApiController::class,'all']);

//search games
Route::get("games-search/{name}",[GameApiController::class,'searchdata']);

//serachplace
Route::get("serachplace/{name}",[GameApiController::class,'serachplace']);

//serachcityandname
Route::get("serachcityandname/{name}",[GameApiController::class,'serachcityandname']);

//for home all vednor data display
Route::get("getallvendor",[VendorApiController::class,'getallvendor']);


//selected vendor
Route::get("selectedvendor/{id}",[VendorApiController::class,'selectedvendor']);

// selectedgame
Route::get("selectedgame/{id}",[VendorApiController::class,'selectedgame']);

//gettablesbygame
Route::get("gettablesbygame/{id}/{vid}",[VendorApiController::class,'gettablesbygame']);

//selectedtable
Route::get("selectedtable/{id}",[VendorApiController::class,'selectedtable']);


//booking 
Route::post("booking",[VendorApiController::class,'booking']);

//show booking
Route::get("showbooking/{id}",[VendorApiController::class,'showbooking']);

//profile view this is two api if get data use get mathod and if update use put api
Route::match(['get','put'],"profileview/{id}",[ProfileApiController::class,'profileview']);

//loginview
Route::match(['get','post'],"login",[LoginApicontroller::class,'login']);

//checklogin
Route::match(['get','post'],"checklogin",[LoginApicontroller::class,'checklogin']);