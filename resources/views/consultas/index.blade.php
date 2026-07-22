@extends('layouts.master')

@section('title', 'Lista de Consultas')

@section('content')
    <h2>Lista de Consultas</h2>

    {{-- Mensagem de sucesso ou erro --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif


    {{-- Botão para criar nova consulta --}}
    <a href="{{ route('consultas.create') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Nova Consulta
    </a>

    {{-- Botão para verifica tipos de consultas --}}
    <a href="{{ route('tipos_consulta.index') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Tipo de consultas
    </a>

    {{-- Botão para visualizar especialidades --}}
    <a href="{{ route('especialidades.index') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Especialidade por consultas
    </a>

    {{-- Tabela de consultas --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->medico->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('d/m/Y H:i') }}</td>
                    <td>R$ {{ number_format($consulta->valor_consulta, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('consultas.edit', $consulta->id) }}" style="margin-right:10px; color:blue;">Editar</a>
                        <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" style="display:inline;">
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
                    <td colspan="5" style="text-align:center;">Nenhuma consulta cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
