<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PermissionController;


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

Route::group(['prefix' => 'role'] , function (){
    Route::post('store',[PermissionController::class,'store']);
    Route::post('show',[PermissionController::class,'show']);
    Route::post('search',[PermissionController::class,'Index']);
    Route::post('update/{id}',[PermissionController::class,'update']);
    Route::post('delete/{id}',[PermissionController::class,'destroy']);
});

Route::group(['prefix' => 'user'] , function (){
    Route::post('show',[UserController::class,'show']);
    Route::post('store',[UserController::class,'store']);
    Route::post('search',[UserController::class,'index']);
    Route::post('update/{id}',[UserController::class,'update']);
    Route::post('delete/{id}',[UserController::class,'destroy']);
});

Route::group(['prefix' => 'color'] , function (){
    Route::post('store',[ColorController::class,'store']);
    Route::post('show',[ColorController::class,'show']);
    Route::post('search',[ColorController::class,'index']);
    Route::post('update/{id}',[ColorController::class,'update']);
    Route::post('delete/{id}',[ColorController::class,'destroy']);
});

Route::group(['prefix' => 'brand'] , function (){
    Route::post('show',[BrandController::class,'show']);
    Route::post('store',[BrandController::class,'store']);
    Route::post('search',[BrandController::class,'index']);
    Route::post('update/{id}',[BrandController::class,'update'])->where('id','[0-9]+');
    Route::post('delete/{id}',[BrandController::class,'destroy']);
});

Route::group(['prefix' => 'item'] , function (){
    Route::post('show',[ItemController::class,'show']);
    Route::post('store',[ItemController::class,'store']);
    Route::post('search',[ItemController::class,'index']);
    Route::post('update/{id}',[ItemController::class,'update']);
    Route::post('delete/{id}',[ItemController::class,'destroy']);
});



