<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Airport\AirportController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Http\Controllers\Group\GroupController;



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
        
        //Uploads
    
        route::post('/upload-file', [FileController::class, 'upload'])->name("admin.upload-file");

        //Airport

        route::post('/airport', [AirportController::class, 'store'])->name("admin.airport");

        route::get('/airport', [AirportController::class, 'list'])->name("admin.airport.list");
    
        route::put('/airport/{airport_id}', [AirportController::class, 'update'])->name("admin.airport.update");
    
        route::delete('/airport/{airport_id}', [AirportController::class, 'destroy'])->name("admin.airport.delete");
    
        route::post('/airport/restore', [AirportController::class, 'restore'])->name("admin.airport.restore");

        //Service

        route::post('/service', [ServiceController::class, 'store'])->name("admin.service");

        route::get('/service', [ServiceController::class, 'list'])->name("admin.service.list");
    
        route::put('/service/{service_id}', [ServiceController::class, 'update'])->name("admin.service.update");

        route::delete('/service/{service_id}', [ServiceController::class, 'destroy'])->name("admin.service.delete");
    
        route::post('/service/restore', [ServiceController::class, 'restore'])->name("admin.service.restore");

        //Vehicle

        route::post('/vehicle', [VehicleController::class, 'store'])->name("admin.vehicle");

        route::get('/vehicle', [VehicleController::class, 'list'])->name("admin.vehicle.list");
            
        route::put('/vehicle/{vehicle_id}', [VehicleController::class, 'update'])->name("admin.vehicle.update");
        
        route::delete('/vehicle/{vehicle_id}', [VehicleController::class, 'destroy'])->name("admin.vehicle.delete");
            
        route::post('/vehicle/restore', [VehicleController::class, 'restore'])->name("admin.vehicle.restore");

        //Group

        route::post('/group', [GroupController::class, 'store'])->name("admin.group");

        route::get('/group', [GroupController::class, 'list'])->name("admin.group.list");
            
        route::put('/group/{group_id}', [GroupController::class, 'update'])->name("admin.group.update");
        
        route::delete('/group/{group_id}', [GroupController::class, 'destroy'])->name("admin.group.delete");
            
        route::post('/group/restore', [GroupController::class, 'restore'])->name("admin.group.restore");

    });

});