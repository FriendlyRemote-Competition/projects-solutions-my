<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("board", [\App\Http\Controllers\PublicController::class, 'board']);
Route::get("board/{stationCode}", [\App\Http\Controllers\PublicController::class, 'departureScreen']);
