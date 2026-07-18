@extends('layouts.master')

@section('title', 'Medicos')

@section('content')
    <h2>Lista de Medicos</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    {{-- Botão para cadastrar novo medico --}}
    <a href="{{ route('consultas.create') }}" 
       style="display:inline-block; margin-bottom:15px; padding:10px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;">
       Nova Consulta
    </a>

    {{-- Tabela de consultas --}}
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead style="background:#ecf0f1;">
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Data</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->medico->nome }}</td>
                    <td>{{ $consulta->data_atendimento }}</td>
                    <td>R$ {{ number_format($consulta->valor_consulta, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Nenhuma consulta cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
