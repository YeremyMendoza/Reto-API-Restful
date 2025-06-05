<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\JerarquiaOrganizacionalController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['jwt', 'throttle:api'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('departamentos', DepartamentoController::class);

    Route::get('jerarquia', [JerarquiaOrganizacionalController::class, 'jerarquia']);
    Route::get('jerarquia/{value}', [JerarquiaOrganizacionalController::class, 'supervisor']);
});

