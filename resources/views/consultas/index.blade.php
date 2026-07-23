@extends('layouts.master')

@section('title', 'Lista de Consultas')

@section('content')

    <h2>Lista de Consultas</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <a href="{{ route('consultas.create') }}" class="botaoLink">Nova Consulta</a>
    <a href="{{ route('tipos_consulta.index') }}" class="botaoLink">Tipo de consultas</a>
    <a href="{{ route('especialidades.index') }}" class="botaoLink">Especialidade por consultas</a>

    <table id="tabela" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->medico->nome }}</td>
                    <td data-order="{{ $consulta->data_atendimento }}">
                        {{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('d/m/Y H:i') }}
                    </td>
                    <td>R$ {{ number_format($consulta->valor_consulta, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('consultas.edit', $consulta->id) }}" style="margin-right:10px; color:blue;"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red; background:none; border:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
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
                order: [[2, 'desc']] // ordena pela coluna Data, mais recente primeiro
            });
        });
    </script>
@endsection