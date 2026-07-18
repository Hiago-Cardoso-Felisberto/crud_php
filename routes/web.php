<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;

// Rotas iniciais
Route::get('/', [Controller::class, 'index'])->name('home');
Route::get('/consultas', [Controller::class, 'consultas'])->name('consultas.index');
Route::get('/medicos', [Controller::class, 'medicos'])->name('medicos.index');
Route::get('/pacientes', [Controller::class, 'pacientes'])->name('pacientes.index');

// Rotas de consultas
Route::get('/buscar-pacientes', [PacienteController::class, 'buscar'])->name('pacientes.buscar');
Route::get('/buscar-medicos', [MedicoController::class, 'buscar'])->name('medicos.buscar');

// Route::get('/consultas', [UserController:: class,'index'])-> name('consultas.index');   Provavel exclusão
Route::get('/consultas/create', [ConsultaController::class, 'create'])->name('consultas.create');
Route::post('/consultas', [ConsultaController::class,'store'])->name('consultas.store');
// Route::get('/consultas/{user}', [UserController::class,'show'])->name('consultas.show');
// Route::get('/consultas/{user}/edit', [UserController::class,'edit'])->name('consultas.edit');
// Route::put('/consultas/{user}', [UserController::class,'update'])->name('consultas.update');
// Route::delete('/consultas/{user}', [UserController::class,'destroy'])->name('consultas.destroy');


// Rotas de pacientes
// Route::get('/pacientes', [UserController:: class,'index'])-> name('pacientes.index');   Provavel exclusão
Route::get('/pacientes/create', [PacienteController:: class,'create'])-> name('pacientes.create');
Route::post('/pacientes', [PacienteController::class,'store'])->name('pacientes.store');
// Route::get('/pacientes/{user}', [UserController::class,'show'])->name('pacientes.show');
// Route::get('/pacientes/{user}/edit', [UserController::class,'edit'])->name('pacientes.edit');
// Route::put('/pacientes/{user}', [UserController::class,'update'])->name('pacientes.update');
// Route::delete('/pacientes/{user}', [UserController::class,'destroy'])->name('pacientes.destroy');


// Rotas de medicos
// Route::get('/medicos', [UserController:: class,'index'])-> name('medicos.index');      Provavel exclusão
Route::get('/medicos/create', [UserController:: class,'create'])-> name('medicos.create');
Route::post('/medicos', [UserController::class,'store'])->name('medicos.store');
// Route::get('/medicos/{user}', [UserController::class,'show'])->name('medicos.show');
// Route::get('/medicos/{user}/edit', [UserController::class,'edit'])->name('medicos.edit');
// Route::put('/medicos/{user}', [UserController::class,'update'])->name('medicos.update');
// Route::delete('/umedicossers/{user}', [UserController::class,'destroy'])->name('medicos.destroy');




// Exemplo
// Route::get('/users', [UserController:: class,'index'])-> name('users.index');
// Route::get('/users/create', [UserController:: class,'create'])-> name('users.create');
// Route::post('/users', [UserController::class,'store'])->name('users.store');
// Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
// Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
// Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');