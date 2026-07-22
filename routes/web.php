<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\TipoConsultaController;
use App\Http\Controllers\EspecialidadeController;

// Rotas iniciais
Route::get('/', [Controller::class, 'index'])->name('home');
Route::get('/consultas', [Controller::class, 'consultas'])->name('consultas.index');
Route::get('/medicos', [Controller::class, 'medicos'])->name('medicos.index');
Route::get('/pacientes', [Controller::class, 'pacientes'])->name('pacientes.index');

// Rotas de consultas
Route::get('/buscar-pacientes', [PacienteController::class, 'buscar'])->name('pacientes.buscar');
Route::get('/buscar-medicos', [MedicoController::class, 'buscar'])->name('medicos.buscar');

// Route::get('/consultas', [ConsultaController:: class,'index'])-> name('consultas.index');   Provavel exclusão
Route::get('/consultas/create', [ConsultaController::class, 'create'])->name('consultas.create');
Route::post('/consultas', [ConsultaController::class,'store'])->name('consultas.store');
Route::get('/consultas/{consulta}', [ConsultaController::class,'show'])->name('consultas.show');
Route::get('/consultas/{consulta}/edit', [ConsultaController::class,'edit'])->name('consultas.edit');
Route::put('/consultas/{consulta}', [ConsultaController::class,'update'])->name('consultas.update');
Route::delete('/consultas/{consulta}', [ConsultaController::class,'destroy'])->name('consultas.destroy');
Route::get('/consultas/medicos-por-tipo/{id}', [ConsultaController::class, 'medicosPorTipo'])->name('consultas.medicosPorTipo');


// Rotas de pacientes
// Route::get('/pacientes', [PacienteController:: class,'index'])-> name('pacientes.index');   Provavel exclusão
Route::get('/pacientes/create', [PacienteController:: class,'create'])-> name('pacientes.create');
Route::post('/pacientes', [PacienteController::class,'store'])->name('pacientes.store');
Route::get('/pacientes/{paciente}/edit', [PacienteController::class,'edit'])->name('pacientes.edit');
Route::put('/pacientes/{paciente}', [PacienteController::class,'update'])->name('pacientes.update');
Route::delete('/pacientes/{paciente}', [PacienteController::class,'destroy'])->name('pacientes.destroy');


// Rotas de medicos
Route::get('/medicos/especialidades/search', [EspecialidadeController::class, 'search'])->name('especialidades.search');

// Route::get('/medicos', [MedicoController:: class,'index'])-> name('medicos.index');      Provavel exclusão
Route::get('/medicos/create', [MedicoController:: class,'create'])-> name('medicos.create');
Route::post('/medicos', [MedicoController::class,'store'])->name('medicos.store');
Route::get('/medicos/search', [MedicoController::class,'search'])->name('medicos.search');
Route::get('/medicos/{medico}/edit', [MedicoController::class,'edit'])->name('medicos.edit');
Route::put('/medicos/{medico}', [MedicoController::class,'update'])->name('medicos.update');
Route::delete('/medicos/{medico}', [MedicoController::class,'destroy'])->name('medicos.destroy');


// Especialidades
Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');
Route::get('/especialidades/create', [EspecialidadeController::class, 'create'])->name('especialidades.create');
Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidades.store');
Route::get('/especialidades/{especialidade}', [EspecialidadeController::class,'show'])->name('especialidades.show');
Route::get('/especialidades/{especialidade}/edit', [EspecialidadeController::class,'edit'])->name('especialidades.edit');
Route::put('/especialidades/{especialidade}', [EspecialidadeController::class,'update'])->name('especialidades.update');
Route::delete('/especialidades/{especialidade}', [EspecialidadeController::class,'destroy'])->name('especialidades.destroy');


// Tipos de Consulta
Route::get('/tipos-consulta', [TipoConsultaController::class, 'index'])->name('tipos_consulta.index');
Route::get('/tipos-consulta/create', [TipoConsultaController::class, 'create'])->name('tipos_consulta.create');
Route::post('/tipos-consulta', [TipoConsultaController::class, 'store'])->name('tipos_consulta.store');
Route::get('/tipos-consulta/{tipoConsulta}/edit', [TipoConsultaController::class,'edit'])->name('tipos_consulta.edit');
Route::put('/tipos-consulta/{tipoConsulta}', [TipoConsultaController::class,'update'])->name('tipos_consulta.update');
Route::delete('/tipos-consulta/{tipoConsulta}', [TipoConsultaController::class,'destroy'])->name('tipos_consulta.destroy');

// Exemplo
// Route::get('/users', [UserController:: class,'index'])-> name('users.index');
// Route::get('/users/create', [UserController:: class,'create'])-> name('users.create');
// Route::post('/users', [UserController::class,'store'])->name('users.store');
// Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
// Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
// Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');