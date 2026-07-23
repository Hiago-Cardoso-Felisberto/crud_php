@extends('layouts.master')

@section('title', 'Lista de Especialidades')

@section('content')
    <h2>Lista de Especialidades</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Botão para criar nova especialidade --}}
    <a href="{{ route('especialidades.create') }}" class="botaoLink">Nova Especialidade</a>

    {{-- Botão de voltar --}}
    <a href="{{ route('consultas.index') }}" class="botaoVoltarLink">Voltar</a>

    {{-- Tabela de especialidades --}}
    <table id="tabela" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($especialidades as $esp)
                <tr>
                    <td>{{ $esp->nome }}</td>
                    <td>
                        <a href="{{ route('especialidades.edit', $esp->id) }}" 
                           style="margin-right:10px; color:blue;"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('especialidades.destroy', $esp->id) }}" method="POST" style="display:inline;">
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
                order: [[1, 'asc']] // ordena pela coluna Data, mais recente primeiro
            });
        });
    </script>
@endsection