@extends('layouts.master')

@section('title', 'Lista de Tipos de Consulta')

@section('content')
    <h2>Lista de Tipos de Consulta</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

   {{-- Botão para criar novo tipo de consulta --}}
    <a href="{{ route('tipos_consulta.create') }}" 
    style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
    Novo Tipo de Consulta
    </a>

    {{-- Botão de voltar --}}
    <a href="{{ route('consultas.index') }}" 
    style="display:inline-block; margin-bottom:15px; padding:10px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
    Voltar
    </a>

    {{-- Tabela de tipos de consulta --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Nome</th>
                <th>Duração (min)</th>
                <th>Hora Início</th>
                <th>Hora Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nome }}</td>
                    <td>{{ $tipo->duracao }}</td>
                    <td>{{ $tipo->hora_inicio }}</td>
                    <td>{{ $tipo->hora_fim }}</td>
                    <td>
                        <a href="{{ route('tipos_consulta.edit', $tipo->id) }}" style="margin-right:10px; color:blue;">Editar</a>
                        <form action="{{ route('tipos_consulta.destroy', $tipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Nenhum tipo de consulta cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
