<?php

use Illuminate\Support\Facades\Route;
use App\Models\Admin\Service;

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
Route::get("/services/edit/{id}", function($id){

    $service = Service::with(['ServiceInfoRate','ServiceTypes','Prices.Group'])->where("id", $id)->first();
    return view("services.edit.index", ["service" => $service]);

});

Route::view("/groups", "groups.index")->name("groups.index");

Route::view("/towns", "towns.index")->name("towns.index");


