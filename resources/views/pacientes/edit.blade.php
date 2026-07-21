@extends('layouts.master')

@section('title', 'Alteração de paciente')

@section('content')

    <h2>Editar Paciente</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pacientes.update', ['paciente' => $paciente -> id]) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <label for="nome">Nome do paciente:</label>
        <input type="text" id="nome" name="nome" value="{{ $paciente->nome }}">

        <br><br>

        <label for="cpf">Cpf:</label>
        <input type="text" id="cpf" name="cpf" value="{{ $paciente->cpf }}">

        <br><br>

        <label for="data_nascimento">Data de nascimento:</label>
        <input type="date" name="data_nascimento" value="{{ \Carbon\Carbon::parse($paciente->data_nascimento)->format('Y-m-d') }}" required>

        <br><br>

        <label for="telefone">Telefone / Celular:</label>
        <input type="text" name="telefone" value="{{ $paciente->telefone }}" required>

        <br><br>

        <button type="submit" style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">Salvar</button>

        {{-- Botão de voltar --}}
        <a href="{{ route('pacientes.index') }}" 
        style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
        Cancelar e voltar
        </a>
    </form>
   
@endsection
