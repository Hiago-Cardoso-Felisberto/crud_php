<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

// Routes da tela inicial
Route::get('/', [Controller::class, 'index'])->name('home');
Route::get('/consultas', [Controller::class, 'consultas'])->name('consultas.index');
Route::get('/medicos', [Controller::class, 'medicos'])->name('medicos.index');
Route::get('/pacientes', [Controller::class, 'pacientes'])->name('pacientes.index');

// Routes da tela de consulta 
Route::get('/buscar-pacientes', [PacienteController::class, 'buscar'])->name('pacientes.buscar');
Route::get('/buscar-medicos', [MedicoController::class, 'buscar'])->name('medicos.buscar');

Route::get('/consultas/create', [ConsultaController:: class,'create'])-> name('users.create');
Route::post('/users', [UserController::class,'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');



// Route::get('/users', [UserController:: class,'index'])-> name('users.index');
// Route::get('/users/create', [UserController:: class,'create'])-> name('users.create');
// Route::post('/users', [UserController::class,'store'])->name('users.store');
// Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
// Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
// Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');