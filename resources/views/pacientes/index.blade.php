@extends('layouts.master')

@section('title', 'Lista de Pacientes')

@section('content')
    <h2>Lista de Pacientes</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Botão para criar novo paciente --}}
    <a href="{{ route('pacientes.create') }}" class="botaoLink">Novo Paciente </a>

    {{-- Tabela de pacientes --}}
    <table id="tabela" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nome }}</td>
                    <td>{{ $paciente->cpf }}</td>
                    <td>{{ \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') }}</td>
                    <td>{{ $paciente->telefone }}</td>
                    <td>
                        <a href="{{ route('pacientes.edit', $paciente->id) }}" style="margin-right:10px; color:blue;"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" style="display:inline;">
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