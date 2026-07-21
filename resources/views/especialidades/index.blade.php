@extends('layouts.master')

@section('title', 'Lista de Especialidades')

@section('content')
    <h2>Lista de Especialidades</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Botão para criar nova especialidade --}}
    <a href="{{ route('especialidades.create') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Nova Especialidade
    </a>

    {{-- Botão de voltar --}}
    <a href="{{ route('consultas.index') }}" 
    style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
    Voltar
    </a>

    {{-- Tabela de especialidades --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($especialidades as $esp)
                <tr>
                    <td>{{ $esp->nome }}</td>
                    <td>
                        <a href="{{ route('especialidades.edit', $esp->id) }}" 
                           style="margin-right:10px; color:blue;">Editar</a>
                        <form action="{{ route('especialidades.destroy', $esp->id) }}" method="POST" style="display:inline;">
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
                    <td colspan="2" style="text-align:center;">Nenhuma especialidade cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
