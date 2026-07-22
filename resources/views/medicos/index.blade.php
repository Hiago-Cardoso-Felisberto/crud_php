@extends('layouts.master')

@section('title', 'Lista de Médicos')

@section('content')
    <h2>Lista de Médicos</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Botão para criar novo médico --}}
    <a href="{{ route('medicos.create') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Novo Médico
    </a>

    {{-- Tabela de médicos --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Nome</th>
                <th>CRM</th>
                <th>Especialidades</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicos as $medico)
                <tr>
                    <td>{{ $medico->nome }}</td>
                    <td>{{ $medico->crm }}</td>
                    <td>
                        @if($medico->especialidades->isNotEmpty())
                            {{ $medico->especialidades->pluck('nome')->join(', ') }}
                        @else
                            <em>Sem especialidades</em>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('medicos.edit', $medico->id) }}" style="margin-right:10px; color:blue;">Editar</a>
                        <form action="{{ route('medicos.destroy', $medico->id) }}" method="POST" style="display:inline;">
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
                    <td colspan="4" style="text-align:center;">Nenhum médico cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
