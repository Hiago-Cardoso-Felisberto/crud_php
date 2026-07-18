@extends('layouts.master')

@section('title', 'Novo Medico')

@section('content')

    <h2>Criar Medico</h2>

    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <form action="{{ route('medicos.store') }}" method="POST">
        @csrf
        <label for="nome">Paciente:</label>
        <input type="text" id="nome" name="nome">
        <input type="hidden" id="paciente_id" name="paciente_id">

        <br><br>

        <label for="medico">Médico:</label>
        <input type="text" id="medico" name="medico_nome">
        <input type="hidden" id="medico_id" name="medico_id">

        <br><br>

        <label for="data_atendimento">Data:</label>
        <input type="date" name="data_atendimento" required>

        <br><br>

        <label for="valor_consulta">Valor:</label>
        <input type="number" step="0.01" name="valor_consulta" required>

        <br><br>

        <button type="submit">Salvar</button>
    </form>
   
@endsection
