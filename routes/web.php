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

Route::group(['middleware' => ['VerifyToken']], function() {
    
    /************************************Login**************************************/
    //ADMIN LOGIN
    Route::get('/admin/login', 'User\UserController@authenticate')->name("admin.login");

    //ADMIN REGISTER
    Route::get('/admin/register', 'User\UserController@register')->name("admin.register");

});


