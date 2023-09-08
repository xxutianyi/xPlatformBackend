<?php

use App\Http\Controllers\_Foundation as Foundation;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('logout', [Foundation\AuthController::class, 'destroy']);

        Route::post('wework', [Foundation\AuthController::class, 'wework']);
        Route::post('password', [Foundation\AuthController::class, 'password']);
        Route::get('mobile-verify', [Foundation\AuthController::class, 'verifyCode']);
        Route::post('mobile-verify', [Foundation\AuthController::class, 'mobileVerify']);
    });

});

Route::middleware('api')->group(function () {

    Route::prefix('config')->group(function () {
        Route::get('wework', [Foundation\ConfigController::class, 'wework']);
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('audits', Foundation\AuditsController::class);

        Route::get('current', [Foundation\CurrentController::class, 'show']);
        Route::get('current/user', [Foundation\CurrentController::class, 'update']);
        Route::put('current/password', [Foundation\CurrentController::class, 'password']);

        Route::prefix('options')->group(function () {
            Route::get('access', [Foundation\OptionsController::class, 'access']);
            Route::get('roles', [Foundation\OptionsController::class, 'roles']);
            Route::get('users', [Foundation\OptionsController::class, 'users']);
            Route::get('teams', [Foundation\OptionsController::class, 'teams']);
        });

        Route::prefix('structure')->group(function () {
            Route::apiResource('roles', Foundation\RoleController::class);
            Route::apiResource('users', Foundation\UserController::class);
            Route::apiResource('teams', Foundation\TeamController::class);
        });
    });

});
