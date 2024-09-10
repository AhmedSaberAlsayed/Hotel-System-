<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashbord\BookingController;
use App\Http\Controllers\Dashbord\PaymentController;
use App\Http\Controllers\Dashbord\Auth\GuestController;
use App\Http\Controllers\Dashbord\Auth\StaffController;
use App\Http\Controllers\Dashbord\Rooms\RoomController;
use App\Http\Controllers\Dashbord\Rooms\RoomTypeController;
use App\Http\Controllers\Dashbord\Auth\DepartmentController;
use App\Http\Controllers\Dashbord\Services\ServiceController;



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
Route::apiResource('Guest',GuestController::class);
Route::post('Register', [GuestController::class, "register"]);
Route::apiResource('Staff',StaffController::class);
Route::apiResource('Department',DepartmentController::class);
Route::apiResource('RoomType',RoomTypeController::class);
Route::apiResource('Room',RoomController::class);
Route::apiResource('Services',ServiceController::class);
Route::apiResource('Booking',BookingController::class);
Route::apiResource('Paument',PaymentController::class);
Route::post('stripe-payment', [PaymentController::class, 'stripePost'])->middleware('auth:sanctum');
