<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

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

    /*Route::group(['middleware' => ['VerifyToken']], function() {
    


    });*/

});