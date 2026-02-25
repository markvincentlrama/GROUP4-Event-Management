<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;

// Your custom authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// The default Sanctum route (protected)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/events', [EventsController::class, 'store']);    // POST /api/events
Route::put('/events/{id}', [EventsController::class, 'update']);  // PUT /api/events/{id}
Route::patch('/events/{id}', [EventsController::class, 'update']); // PATCH /api/events/{id}
Route::delete('/events/{id}', [EventsController::class, 'destroy']); // DELETE /api/events/{id}