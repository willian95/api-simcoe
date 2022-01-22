<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes(['register' => false]);

//ADMIN REGISTER
Route::post('/admin/register', 'User\UserController@register')->name("admin.register");

Route::group(['middleware' => ['VerifyToken']], function() {
    
    /************************************Login**************************************/
    //ADMIN LOGIN
    Route::post('/admin/login', 'User\UserController@authenticate')->name("admin.login");

});


