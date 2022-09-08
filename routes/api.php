<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('v1/users', App\Http\Controllers\Api\V1\UserController::class)->middleware('auth:sanctum');

Route::post('v1/users2', [App\Http\Controllers\Api\V1\UserController::class,'buscarId'])->middleware('auth:sanctum');
Route::put('v1/users', [App\Http\Controllers\Api\V1\UserController::class,'update'])->middleware('auth:sanctum');
Route::post('v1/users/tipousuario', [App\Http\Controllers\Api\V1\UserController::class,'cambiarTipoUsuario'])->middleware('auth:sanctum');
Route::post('v1/users/password', [App\Http\Controllers\Api\V1\UserController::class,'changepassword'])->middleware('auth:sanctum');
Route::post('login', [
    App\Http\Controllers\Api\LoginController::class,
    'login'
]);


Route::apiResource('v1/tipovehiculos', App\Http\Controllers\Api\V1\TipoVehiculoController::class)->middleware('auth:sanctum');
Route::put('v1/tipovehiculos', [App\Http\Controllers\Api\V1\TipoVehiculoController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/tipovehiculos', [App\Http\Controllers\Api\V1\TipoVehiculoController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/tipovehiculos2', [App\Http\Controllers\Api\V1\TipoVehiculoController::class,'buscarId'])->middleware('auth:sanctum');

Route::apiResource('v1/tiporeportes', App\Http\Controllers\Api\V1\TipoReporteController::class)->middleware('auth:sanctum');
Route::put('v1/tiporeportes', [App\Http\Controllers\Api\V1\TipoReporteController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/tiporeportes', [App\Http\Controllers\Api\V1\TipoReporteController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/tiporeportes2', [App\Http\Controllers\Api\V1\TipoReporteController::class,'buscarId'])->middleware('auth:sanctum');

Route::apiResource('v1/sedes', App\Http\Controllers\Api\V1\SedeController::class)->middleware('auth:sanctum');
Route::put('v1/sedes', [App\Http\Controllers\Api\V1\SedeController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/sedes', [App\Http\Controllers\Api\V1\SedeController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/sedes2', [App\Http\Controllers\Api\V1\SedeController::class,'buscarId'])->middleware('auth:sanctum');

Route::apiResource('v1/periodos', App\Http\Controllers\Api\V1\PeriodoController::class)->middleware('auth:sanctum');
Route::put('v1/periodos', [App\Http\Controllers\Api\V1\PeriodoController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/periodos', [App\Http\Controllers\Api\V1\PeriodoController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/periodos2', [App\Http\Controllers\Api\V1\PeriodoController::class,'buscarId'])->middleware('auth:sanctum');


Route::apiResource('v1/vehiculos', App\Http\Controllers\Api\V1\VehiculoController::class)->middleware('auth:sanctum');
Route::put('v1/vehiculos', [App\Http\Controllers\Api\V1\VehiculoController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/vehiculos', [App\Http\Controllers\Api\V1\VehiculoController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/vehiculos2', [App\Http\Controllers\Api\V1\VehiculoController::class,'buscarId'])->middleware('auth:sanctum');
Route::post('v1/vehiculos3', [App\Http\Controllers\Api\V1\VehiculoController::class,'buscarPlaca'])->middleware('auth:sanctum');
Route::get('v1/vehiculos2', [App\Http\Controllers\Api\V1\VehiculoController::class,'listado_pendiente'])->middleware('auth:sanctum');
Route::post('v1/vehiculos4', [App\Http\Controllers\Api\V1\VehiculoController::class,'asignar_usuario'])->middleware('auth:sanctum');
Route::delete('v1/vehiculos2', [App\Http\Controllers\Api\V1\VehiculoController::class,'desasignar_usuario'])->middleware('auth:sanctum');


Route::apiResource('v1/reportes', App\Http\Controllers\Api\V1\ReporteController::class)->middleware('auth:sanctum');
Route::put('v1/reportes', [App\Http\Controllers\Api\V1\ReporteController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/reportes', [App\Http\Controllers\Api\V1\ReporteController::class,'destroy'])->middleware('auth:sanctum');
Route::post('v1/reportes2', [App\Http\Controllers\Api\V1\ReporteController::class,'buscarId'])->middleware('auth:sanctum');
Route::get('v1/reportes2', [App\Http\Controllers\Api\V1\ReporteController::class,'reportes_desbloqueados'])->middleware('auth:sanctum');
Route::post('v1/reportes3', [App\Http\Controllers\Api\V1\ReporteController::class,'buscarPlaca'])->middleware('auth:sanctum');