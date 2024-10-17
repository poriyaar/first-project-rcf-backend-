<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\user\UserController;

// Authentication Route
Route::prefix("/users")->group(function () {

    Route::get('/leaderboards', [UserController::class, 'leaderboards'])->name('users.leaderboards');
});
