<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HeaderApiController;
use App\Http\Controllers\Api\FooterApiController;
use App\Http\Controllers\Api\HomeContentController;
use App\Http\Controllers\Api\InvestorCorner;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ContactPageApi;
use App\Http\Controllers\Api\HeroSectionController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Login route
Route::post("login", [LoginController::class, 'login']);
Route::post("register", [LoginController::class, 'registerAdmin']);

// Route::apiResource('header', HeaderApiController::class);
Route::apiResource('footer', FooterApiController::class);
Route::apiResource("profile", ProfileController::class);
// Group routes protected
Route::group(["middleware"=> "auth:sanctum"], function(){
    Route::get("dashboard", [LoginController::class, 'showDashboard']);
    Route::get("logout", [LoginController::class, 'logout']);
});

Route::apiResource('homedata', HomeContentController::class);
Route::apiResource('headerlogo', HeaderApiController::class);
Route::apiResource('investorPage', InvestorCorner::class);
Route::apiResource('ContactPage', ContactPageApi::class);
Route::apiResource('heroSection', HeroSectionController::class);


// route::put('homedata', [HomeContentController::class, 'update']);

Route::apiResource('products', ProductsController::class);
Route::apiResource('categories', CategoryController::class);
