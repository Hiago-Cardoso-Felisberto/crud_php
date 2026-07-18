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
        <input type="text" id="nome" name="nome">

        <br><br>

        <label for="cpf">Cpf:</label>
        <input type="text" id="cpf" name="cpf">

        <br><br>

        <label for="data_nascimento">Data de nascimento:</label>
        <input type="date" name="data_nascimento" required>

        <br><br>

        <label for="telefone">Telefone / Celular:</label>
        <input type="number" name="telefone" required>

        <br><br>

        <button type="submit">Salvar</button>
    </form>
   
@endsection
