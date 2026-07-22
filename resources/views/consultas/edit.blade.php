@extends('layouts.master')

@section('title', 'Editar Consulta')

@section('content')
    <h2>Editar Consulta</h2>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    {{-- Mensagem de erros de validação --}}
    @if ($errors->any())
        <div style="color:red; background-color:#f8d7da; padding:10px; border-radius:5px; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('consultas.update', ['consulta' => $consulta->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Campo Paciente com autocomplete --}}
        <label for="paciente">Paciente:</label>
        <input type="text" id="paciente" name="paciente_nome" value="{{ $consulta->paciente->nome }}">
        <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $consulta->paciente_id }}">
        <br><br>

        <label for="tipo_consulta_id">Tipo de Consulta:</label>
        <select name="tipo_consulta_id" id="tipo_consulta_id" required>
            <option value="">Selecione o tipo de consulta</option>
            @foreach($tiposConsulta as $tipo)
                <option value="{{ $tipo->id }}" {{ $consulta->tipo_consulta_id == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->nome }}
                </option>
            @endforeach
        </select>
        <br><br>

        {{-- Campo Médico com autocomplete --}}
        <label for="medico">Médico:</label>
        <input type="text" id="medico" name="medico_nome" value="{{ $consulta->medico->nome }}" disabled>
        <input type="hidden" id="medico_id" name="medico_id" value="{{ $consulta->medico_id }}">
        <br><br>

        <label for="data_atendimento">Data:</label>
        <input type="date" name="data_atendimento" id="data_atendimento" value="{{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('Y-m-d') }}" required>
        <br><br>

        <label for="hora_atendimento">Hora:</label>
        <input type="time" name="hora_atendimento" id="hora_atendimento" value="{{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('H:i') }}" required>
        <br><br>

        <label for="valor_consulta">Valor:</label>
        <input type="number" step="0.01" name="valor_consulta" id="valor_consulta" value="{{ $consulta->valor_consulta }}" required>
        <br><br>

        <button type="submit" style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">Salvar</button>

        {{-- Botão de voltar --}}
        <a href="{{ route('consultas.index') }}" 
        style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
        Cancelar e voltar
        </a>
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
                                response([{ label: "Paciente não encontrado. Deseja cadastrar?", value: request.term, id: null }]);
                            } else {
                                response($.map(data, function(item) {
                                    return { label: item.nome, value: item.nome, id: item.id };
                                }));
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    if (ui.item.id) {
                        $("#paciente_id").val(ui.item.id);
                    } else {
                        if (confirm("Paciente não encontrado. Deseja cadastrar?")) {
                            window.location.href = "{{ route('pacientes.create') }}";
                        }
                    }
                }
            });

            $("#tipo_consulta_id").change(function() {
                const tipoId = $(this).val();
                if (!tipoId) {
                    $("#medico").prop("disabled", true);
                    return;
                }

                $("#medico").prop("disabled", false).val("").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "/consultas/medicos-por-tipo/" + tipoId,
                            data: { term: request.term },
                            success: function(data) {
                                if (data.length === 0) {
                                    response([{ label: "Nenhum médico disponível para este tipo", value: request.term, id: null }]);
                                } else {
                                    response($.map(data, function(item) {
                                        return { label: item.nome, value: item.nome, id: item.id };
                                    }));
                                }
                            }
                        });
                    },
                    select: function(event, ui) {
                        if (ui.item.id) {
                            $("#medico_id").val(ui.item.id);
                        } 
                        else {
                            if (confirm("Médico não encontrado. Deseja cadastrar?")) {
                                window.location.href = "{{ route('medicos.create') }}";
                            }
                        }
                    }
                });
            });

        });
    </script>
@endsection
