<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use app\Models\User;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/leaves', [LeaveController::class, 'getLeaves'])->middleware('is.manager')->name('getLeaves');
    Route::post('/leaves', [LeaveController::class, 'storeLeaves'])->middleware('is.manager')->name('storeLeaves');

    Route::get('/user/leaves', [LeaveController::class, 'getUserLeaves'])->name('getUserLeaves');

    Route::patch('/leaves/{id}/approve', [LeaveController::class, 'approve'])->middleware('is.manager')->name('approve');
    Route::patch('/leaves/{id}/reject', [LeaveController::class, 'reject'])->middleware('is.manager')->name('reject');
    Route::get('/users', [AuthController::class, 'getUsers'])->middleware('is.manager')->name('getUsers');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
