@extends('layouts.master')

@section('title', 'Cadastro de paciente')

@section('content')

    <h2>Cadastrar Paciente</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf
        <label for="nome">Nome do paciente:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}">

        <br><br>

        <label for="cpf">Cpf:</label>
        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}">

        <br><br>

        <label for="data_nascimento">Data de nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}" required>

        <br><br>

        <label for="telefone">Telefone / Celular:</label>
        <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" required>

        <br><br>

        <button type="submit" style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">Salvar</button>

        {{-- Botão de voltar --}}
        <a href="{{ route('pacientes.index') }}" 
        style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
        Cancelar e voltar
        </a>

    </form>
   
@endsection
