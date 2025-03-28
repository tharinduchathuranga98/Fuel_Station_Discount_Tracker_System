<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\VehicleController;

Route::post('/register-vehicle', [VehicleController::class, 'register']);
Route::put('/vehicles/{number_plate}', [VehicleController::class, 'updateVehicle']);
Route::delete('/vehicles/{number_plate}', [VehicleController::class, 'deleteVehicle']);
Route::get('/vehicles', [VehicleController::class, 'index']);

Route::post('/get-user-refueling', [VehicleController::class, 'getUserRefuelingData']);

Route::get('/vehicles/{id}/qr-code', [VehicleController::class, 'getQrCode']);

use App\Http\Controllers\RefuelingController;

Route::post('/refueling', [RefuelingController::class, 'recordRefueling']);

use App\Http\Controllers\FuelTypeController;

Route::prefix('fuel-types')->group(function () {
    Route::post('/', [FuelTypeController::class, 'store']); // Create
    Route::get('/', [FuelTypeController::class, 'index']); // Get all
    Route::get('/{id}', [FuelTypeController::class, 'show']); // Get one
    Route::put('/{id}', [FuelTypeController::class, 'update']); // Update
    Route::delete('/{id}', [FuelTypeController::class, 'destroy']); // Delete
});

use App\Http\Controllers\FuelCategoryController;


Route::get('/fuel-categories', [FuelCategoryController::class, 'index']);
Route::post('/fuel-categories', [FuelCategoryController::class, 'store']);
Route::get('/fuel-categories/{code}', [FuelCategoryController::class, 'show']);
Route::put('/fuel-categories/{code}', [FuelCategoryController::class, 'update']);
Route::delete('/fuel-categories/{code}', [FuelCategoryController::class, 'destroy']);
Route::post('/check-vehicle', [VehicleController::class, 'checkVehicle']);
Route::get('/refueling/daily-report', [RefuelingController::class, 'dailyReport']);
Route::get('/refueling/monthly-report', [RefuelingController::class, 'monthlyReport']);
