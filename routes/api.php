<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Airport\AirportController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|   //
*/


Route::group(["prefix" => "admin"], function(){

    
    Route::post('/register', [UserController::class, 'register'])->name("admin.register");

    Route::post('/login', [UserController::class, 'authenticate'])->name("admin.login");

    Route::group(['middleware' => ['VerifyToken']], function() {
    
        route::post('/upload-file', [FileController::class, 'upload'])->name("admin.upload-file");

        //Airport

        route::post('/airport', [AirportController::class, 'store'])->name("admin.airport");

        route::get('/airport', [AirportController::class, 'list'])->name("admin.airport.list");
    
        route::put('/airport/{airport_id}', [AirportController::class, 'update'])->name("admin.airport.update");
    
        route::delete('/airport/{airport_id}', [AirportController::class, 'destroy'])->name("admin.airport.delete");
    
        route::post('/airport/restore', [AirportController::class, 'restore'])->name("admin.airport.restore");


    });

});