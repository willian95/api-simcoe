<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

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

Route::view("/", "welcome");

Route::view("/dashboard", "dashboard");

Route::view("/airports", "airports.index")->name("airports.index");

Route::view("/services", "services.list.index")->name("services.index");
Route::view("/services/create", "services.create.index")->name("services.create");

Route::view("/groups", "groups.index")->name("groups.index");

