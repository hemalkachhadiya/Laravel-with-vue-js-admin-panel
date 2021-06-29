<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TabController;
use App\Http\Controllers\Api\MenuTypesController;
use App\Http\Controllers\Api\AuthController;

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






Route::group(['namespace' => 'Api'],function (){
        Route::get('/tabs',[TabController::class,'index']);
        Route::get('/menu-types',[MenuTypesController::class,'index']);
        Route::post('/menu-types/store',[MenuTypesController::class,'store']);
        Route::get('/menu-types/edit/{id}',[MenuTypesController::class,'edit']);
        Route::post('/menu-types/update',[MenuTypesController::class,'update']);
        Route::get('/menu-types/delete/{id}',[MenuTypesController::class,'delete']);
        Route::post('/menu-types/muldelete',[MenuTypesController::class,'muldelete']);
        Route::post('/menu-types/changeimage',[MenuTypesController::class,'changeimage']);

});
