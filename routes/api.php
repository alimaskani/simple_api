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



Route::group(['prefix' => 'user'] , function (){
    Route::post('store',[UserController::class,'Store']);
    Route::post('update/{id}',[UserController::class,'Update']);
    Route::post('delete/{id}',[UserController::class,'destroy']);
    Route::post('search',[UserController::class,'Index']);
});

Route::group(['prefix' => 'role'] , function (){
    Route::post('store',[PermissionController::class,'Store']);
    Route::post('update/{id}',[PermissionController::class,'Update']);
    Route::post('delete/{id}',[PermissionController::class,'destroy']);
    Route::post('search',[PermissionController::class,'Index']);
});

Route::group(['prefix' => 'color'] , function (){
    Route::post('store',[ColorController::class,'Store']);
    Route::post('search',[ColorController::class,'Index']);
    Route::post('update/{id}',[ColorController::class,'Update']);
    Route::post('delete/{id}',[ColorController::class,'destroy']);
});

Route::group(['prefix' => 'brand'] , function (){
    Route::post('search',[BrandController::class,'Index']);
    Route::post('store',[BrandController::class,'Store']);
    Route::post('update/{id}',[BrandController::class,'Update']);
    Route::post('delete/{id}',[BrandController::class,'destroy']);
});

Route::group(['prefix' => 'item'] , function (){
    Route::post('store',[ItemController::class,'Store']);
    Route::post('search',[ItemController::class,'Index']);
    Route::post('update/{id}',[ItemController::class,'Update']);
    Route::post('delete/{id}',[ItemController::class,'Destroy']);
});



