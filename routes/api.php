<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DepartamentoController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['jwt'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('departamentos', DepartamentoController::class)->except(['show']);
    Route::get('departamentos/search', [DepartamentoController::class, 'search']);
});
