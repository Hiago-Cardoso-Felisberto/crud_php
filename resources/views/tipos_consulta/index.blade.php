@extends('layouts.master')

@section('title', 'Lista de Tipos de Consulta')

@section('content')
    <h2>Lista de Tipos de Consulta</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

   {{-- Botão para criar novo tipo de consulta --}}
    <a href="{{ route('tipos_consulta.create') }}" class="botaoLink"> Novo Tipo de Consulta </a>

    {{-- Botão de voltar --}}
    <a href="{{ route('consultas.index') }}" class="botaoVoltarLink"> Voltar </a>

    {{-- Tabela de tipos de consulta --}}
    <table id="tabela" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Duração (min)</th>
                <th>Hora Início</th>
                <th>Hora Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nome }}</td>
                    <td>{{ $tipo->duracao }}</td>
                    <td>{{ $tipo->hora_inicio }}</td>
                    <td>{{ $tipo->hora_fim }}</td>
                    <td>
                        <a href="{{ route('tipos_consulta.edit', $tipo->id) }}" style="margin-right:10px; color:blue;"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('tipos_consulta.destroy', $tipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabela').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
                },
                order: [[0, 'asc']] // ordena pela coluna Data, mais recente primeiro
            });
        });
    </script>
@endsection