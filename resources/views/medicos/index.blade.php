@extends('layouts.master')

@section('title', 'Lista de Consultas')

@section('content')
<div class="dashboard">
    <a href="{{ route('consultas.index') }}" class="card">
        <span>📅</span>
        Consultas
    </a>
    <a href="{{ route('medicos.index') }}" class="card">
        <span>🩺</span>
        Médicos
    </a>
    <a href="{{ route('pacientes.index') }}" class="card">
        <span>👩‍⚕️</span>
        Pacientes
    </a>
</div>
@endsection
