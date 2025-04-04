<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FuelCategoryController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\RefuelingController;
use App\Http\Controllers\CreditController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\RefuelingReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicle-management');

Route::get('/', function () {
    return response()->redirectTo('/dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');

use App\Http\Controllers\VehicleController;
use App\Models\FuelCategory;

Route::get('/vehicles/vehicle-management', [VehicleController::class, 'index'])->name('vehicle-management')->middleware('auth');
Route::get('/vehicles/vehicle-management/{number_plate}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit')->middleware('auth');
Route::put('/vehicles/vehicle-management/{number_plate}', [VehicleController::class, 'updateVehicle'])->name('vehicles.update')->middleware('auth');
Route::get('/vehicles/{id}/qr', [VehicleController::class, 'getQrCode'])->name('vehicles.qr')->middleware('auth');
Route::get('/get-categories', [VehicleController::class, 'getCategoriesByFuelType'])->name('getCategoriesByFuelType');
Route::delete('/vehicles/vehicle-management/{number_plate}', [VehicleController::class, 'deleteVehicle'])->name('vehicles.destroy')->middleware('auth');
Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create')->middleware('auth');
Route::post('/vehicles/create', [VehicleController::class, 'register'])->name('vehicles.store')->middleware('auth');



Route::get('/fuel-type/fuel-type-management', [FuelTypeController::class, 'index'])->name('fuel-type-management')->middleware('auth');
Route::get('/fuel-type/fuel-type-management/edit/{id}', [FuelTypeController::class, 'show'])->name('fuel-type.edit')->middleware('auth');
Route::put('/fuel-type/fuel-type-management/{id}', [FuelTypeController::class, 'update'])->name('fuel-type.update')->middleware('auth');
Route::get('/fuel-type/fuel-type-management/create', [FuelTypeController::class, 'create'])->name('fuel-type.create')->middleware('auth');
Route::post('/fuel-type/fuel-type-management/create', [FuelTypeController::class, 'store'])->name('fuel-type.store')->middleware('auth');
Route::delete('/fuel-type/fuel-type-management/{id}', [FuelTypeController::class, 'destroy'])->name('fuel-type.destroy')->middleware('auth');


Route::get('/categorys/category-management', [FuelCategoryController::class, 'index'])->name('category-management')->middleware('auth');
Route::get('/categorys/category-management/edit/{code}', [FuelCategoryController::class, 'show'])->name('category.edit')->middleware('auth');
Route::put('/categorys/category-management/{code}', [FuelCategoryController::class, 'update'])->name('category.update')->middleware('auth');
Route::get('/categorys/category-management/create', [FuelCategoryController::class, 'create'])->name('category.create')->middleware('auth');
Route::post('/categorys/category-management/create', [FuelCategoryController::class, 'store'])->name('category.store')->middleware('auth');
// Route::delete('/fuel-type/fuel-type-management/{id}', [FuelTypeController::class, 'destroy'])->name('fuel-type.destroy')->middleware('auth');

Route::get('/refueling/daily-report', [RefuelingController::class, 'dailyReport'])->name('daylyreport.view')->middleware('auth');
Route::get('/refueling/monthly-report', [RefuelingController::class, 'monthlyReport'])->name('monthlyreport.test')->middleware('auth');

Route::get('/refueling/refueling-management', [RefuelingController::class, 'index'])->name('refueling-management')->middleware('auth');
// Route::post('refueling-report', [RefuelingReportController::class, 'generateReport'])->name('refueling-report')->middleware('auth');
Route::get('/refueling-report-form', [RefuelingReportController::class, 'generateReport'])->name('refueling-report-form')->middleware('auth');
Route::get('/credit-list', [CreditController::class, 'showCreditList'])->name('credit-list')->middleware('auth');
Route::post('/pay-credit', [CreditController::class, 'storeDebit'])->name('credits.pay')->middleware('auth');
Route::get('/reports/select-month', [RefuelingReportController::class, 'showSelectMonthForm'])->name('select-month')->middleware('auth');
Route::get('/reports/monthly', [RefuelingReportController::class, 'generateMonthlyReport'])->name('report-month')->middleware('auth');
