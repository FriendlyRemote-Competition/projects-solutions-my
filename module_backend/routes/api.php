<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DepartureController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\ServiceWindowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/test", function () {return "test";});

Route::prefix("admin")->group(function () {
    Route::post("login", [AuthController::class, "login"]);

    Route::middleware("auth:api")->group(function () {
        Route::post("departures/{code}/cancel", [DepartureController::class, "destroy"]);

        Route::middleware("check:admin")->group(function () {
            Route::get("bookings", [BookingController::class, "index"]);
            Route::post("lines", [LineController::class, "store"]);
            Route::put("lines/{code}", [LineController::class, "update"]);
            Route::post("lines/{code}/service-windows", [ServiceWindowController::class, "store"]);
            Route::delete("lines/{code}/service-windows/{start_time}", [ServiceWindowController::class, "destroy"]);
        });
    });
});

Route::get("lines", [LineController::class, "index"]);
Route::get("lines/{code}", [LineController::class, "show"]);
Route::get('lines/{code}/timetable', [LineController::class, "showTimetable"]);

Route::post("bookings", [BookingController::class, "store"]);
Route::post("bookings/lookup", [BookingController::class, "show"]);
Route::patch("bookings/{code}", [BookingController::class, "update"]);
Route::post("bookings/{code}/cancel", [BookingController::class, "destroy"]);
