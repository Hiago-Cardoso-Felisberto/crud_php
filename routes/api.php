<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ConsultaApiController;
use App\Http\Controllers\Api\PacienteApiController;
use App\Http\Controllers\Api\MedicoApiController;
use App\Http\Controllers\Api\EspecialidadeApiController;
use App\Http\Controllers\Api\TipoConsultaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Estas rotas são utilizadas para comunicação via API REST.
| Todas retornam respostas em JSON e podem ser consumidas por
| aplicações Web, Mobile ou pelo Swagger/OpenAPI.
|
*/


// Consultas
Route::apiResource('consultas', ConsultaApiController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->names('api.consultas');


Route::get(
    'consultas/medicos-por-tipo/{id}',
    [ConsultaApiController::class, 'medicosPorTipo']
)->name('api.consultas.medicosPorTipo');



// Pacientes
Route::get(
    'pacientes/search',
    [PacienteApiController::class, 'search']
)->name('api.pacientes.search');


Route::apiResource('pacientes', PacienteApiController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->names('api.pacientes');



// Médicos
Route::get(
    'medicos/search',
    [MedicoApiController::class, 'search']
)->name('api.medicos.buscar');


Route::apiResource('medicos', MedicoApiController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->names('api.medicos');



// Especialidades
Route::get(
    'especialidades/search',
    [EspecialidadeApiController::class, 'search']
)->name('api.especialidades.search');


Route::apiResource('especialidades', EspecialidadeApiController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->names('api.especialidades');



// Tipos de Consulta
Route::apiResource('tipos-consulta', TipoConsultaApiController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->names('api.tipos_consulta');