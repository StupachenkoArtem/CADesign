<?php

use App\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/books')->group(function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
});

Route::prefix('api/reservations')->group(function () {
    Route::get('/', [ReservationController::class, 'listReservations']);
    Route::post('/{bookId}', [ReservationController::class, 'reserveBook']);
    Route::put('/return/{reservationId}', [ReservationController::class, 'returnBook']);
    Route::delete('/{reservationId}', [ReservationController::class, 'deleteReservation']);
});

Route::middleware('api')->group(function () {
    Route::get('/api/users', [UserController::class, 'listUsers']);
    Route::get('/api/users/{id}', [UserController::class, 'getUser']);
    Route::post('/api/users', [UserController::class, 'createUser ']);
    Route::put('/api/users/{id}', [UserController::class, 'updateUser ']);
    Route::delete('/api/users/{id}', [UserController::class, 'deleteUser ']);
});