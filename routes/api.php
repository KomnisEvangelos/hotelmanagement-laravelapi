<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\BookingController;
use  App\Http\Controllers\Api\CustomerController;

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

//customers
Route::get('customers',[CustomerController::class, 'index']);
Route::post('customers',[CustomerController::class, 'store']);
Route::get('customers/{id}',[CustomerController::class, 'show']);
Route::get('customers/{id}/edit',[CustomerController::class, 'edit']);
Route::put('customers/{id}/edit',[CustomerController::class, 'update']);
Route::delete('customers/{id}/delete',[CustomerController::class, 'destroy']);

//rooms
Route::get('rooms',[RoomController::class, 'index']);
Route::post('rooms',[RoomController::class, 'store']);
Route::get('rooms/{id}',[RoomController::class, 'show']);
Route::get('rooms/{id}/edit',[RoomController::class, 'edit']);
Route::put('rooms/{id}/edit',[RoomController::class, 'update']);
Route::delete('rooms/{id}/delete',[RoomController::class, 'destroy']);
Route::get('rooms/get-room-by-number/{roomnumber}', [RoomController::class, 'getRoomByNumber']);

//Bookings
Route::get('bookings',[BookingController::class, 'index']);
Route::post('bookings',[BookingController::class, 'store']);
Route::get('bookings/{id}',[BookingController::class, 'show']);
Route::get('bookings/{id}/edit',[BookingController::class, 'edit']);
Route::put('bookings/{id}/edit',[BookingController::class, 'update']);
Route::delete('bookings/{id}/delete',[BookingController::class, 'destroy']);


