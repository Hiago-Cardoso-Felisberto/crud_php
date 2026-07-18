@extends('layouts.master')

@section('title', 'Nova Consulta')

@section('content')

    <h2>Criar Consulta</h2>

    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <form action="{{ route('consultas.store') }}" method="POST">
        @csrf

        {{-- Campo Paciente com autocomplete --}}
        <label for="paciente">Paciente:</label>
        <input type="text" id="paciente" name="paciente_nome">
        <input type="hidden" id="paciente_id" name="paciente_id">

        <br><br>

        {{-- Campo Médico com autocomplete --}}
        <label for="medico">Médico:</label>
        <input type="text" id="medico" name="medico_nome">
        <input type="hidden" id="medico_id" name="medico_id">

        <br><br>

        <label for="tipo_consulta_id">Tipo de Consulta:</label>
        <select name="tipo_consulta_id" required>
            <option value="">Selecione o tipo de consulta</option>
            @foreach($tiposConsulta as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
            @endforeach
        </select>

        <br><br>

        <label for="data_atendimento">Data:</label>
        <input type="date" name="data_atendimento" required>

        <br><br>

        <label for="hora_atendimento">Hora:</label>
        <input type="time" name="hora_atendimento" required>

        <br><br>

        <label for="valor_consulta">Valor:</label>
        <input type="number" step="0.01" name="valor_consulta" required>

        <br><br>

        <button type="submit">Salvar</button>
    </form>

    {{-- jQuery UI Autocomplete --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script>
        $(function() {
            // Autocomplete Paciente
            $("#paciente").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('pacientes.buscar') }}",
                        data: { term: request.term },
                        success: function(data) {
                            if (data.length === 0) {
                                // Nenhum paciente encontrado
                                response([{ 
                                    label: "Paciente não encontrado. Deseja cadastrar?", 
                                    value: request.term, 
                                    id: null 
                                }]);
                            } else {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.nome,
                                        value: item.nome,
                                        id: item.id
                                    };
                                }));
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    if (ui.item.id) {
                        // Paciente existente
                        $("#paciente_id").val(ui.item.id);
                    } else {
                        // Nenhum paciente encontrado → redireciona para tela de cadastro
                        if (confirm("Paciente não encontrado. Deseja cadastrar?")) {
                            window.location.href = "{{ route('pacientes.create') }}";
                        }
                    }
                }
            });

            // Autocomplete Médico
            $("#medico").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('medicos.buscar') }}",
                        data: { term: request.term },
                        success: function(data) {
                            if (data.length === 0) {
                                // Nenhum medico encontrado
                                response([{ 
                                    label: "Medico não encontrado. Deseja cadastrar?", 
                                    value: request.term, 
                                    id: null 
                                }]);
                            } else {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.nome,
                                        value: item.nome,
                                        id: item.id
                                    };
                                }));
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    if (ui.item.id) {
                        // Paciente existente
                        $("#medico_id").val(ui.item.id);
                    } else {
                        // Nenhum paciente encontrado → redireciona para tela de cadastro
                        if (confirm("Medico não encontrado. Deseja cadastrar?")) {
                            window.location.href = "{{ route('medicos.create') }}";
                        }
                    }
                }
            });
        });
    </script>
@endsection
