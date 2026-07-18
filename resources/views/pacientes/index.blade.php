@extends('layouts.master')

@section('title', 'Pacientes')

@section('content')
    <h2>Lista de Pacientes</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    {{-- Botão para criar novo paciente --}}
    <a href="{{ route('consultas.create') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Nova Consulta
    </a>

    {{-- Tabela de consultas --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Paciente</th>
                <th>Cpf</th>
                <th>Data de nascimento</th>
                <th>Telefone / Celular</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nome }}</td>
                    <td>{{ $paciente->cpf }}</td>
                    <td>{{ $paciente->data_nascimento }}</td>
                    <td>{{ $paciente->telefone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Nenhum paciente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
