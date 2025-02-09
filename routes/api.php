<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShiftController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/employees', 'get');
        Route::post('/employee', 'show');
        Route::post('/logout', 'logout');
        Route::patch('/update-availability', 'update');
    });

    Route::prefix('shifts')->controller(ShiftController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('create', 'store');
        Route::patch('update', 'update');
        Route::delete('delete', 'destroy');
    });

    Route::prefix('assignments')->controller(AssignmentController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('update', 'update');
        Route::post('auto-assign', 'autoAssign');
    });

});
