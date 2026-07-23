@extends('layouts.master')

@section('title', 'Lista de Médicos')

@section('content')
    <h2>Lista de Médicos</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Botão para criar novo médico --}}
    <a href="{{ route('medicos.create') }}" class="botaoLink"> Novo Médico </a>

    {{-- Tabela de médicos --}}
    <table id="tabela" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CRM</th>
                <th>Especialidades</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicos as $medico)
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
                        <a href="{{ route('medicos.edit', $medico->id) }}" style="margin-right:10px; color:blue;"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('medicos.destroy', $medico->id) }}" method="POST" style="display:inline;">
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