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


    <form action="{{ route('consultas.update', ['consulta' => $consulta->id]) }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Paciente --}}
            <div class="col-md-6">
                <label for="paciente" class="form-label">Paciente</label>
                <input type="text" id="paciente" name="paciente_nome" class="form-control" value="{{ $consulta->paciente->nome }}">
                <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $consulta->paciente_id }}">
            </div>

            {{-- Tipo de Consulta --}}
            <div class="col-md-6">
                <label for="tipo_consulta_id" class="form-label">Tipo de Consulta</label>
                <select name="tipo_consulta_id" id="tipo_consulta_id" class="form-select" required>
                    <option value="">Selecione o tipo de consulta</option>
                    @foreach($tiposConsulta as $tipo)
                        <option value="{{ $tipo->id }}" {{ $consulta->tipo_consulta_id == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Médico --}}
            <div class="col-md-6">
                <label for="medico" class="form-label">Médico</label>
                <input type="text" id="medico" name="medico_nome" class="form-control" value="{{ $consulta->medico->nome }}" disabled>
                <input type="hidden" id="medico_id" name="medico_id" value="{{ $consulta->medico_id }}">
            </div>

            {{-- Data --}}
            <div class="col-md-3">
                <label for="data_atendimento" class="form-label">Data</label>
                <input type="date" name="data_atendimento" id="data_atendimento" class="form-control" value="{{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('Y-m-d') }}" required>
            </div>

            {{-- Hora --}}
            <div class="col-md-3">
                <label for="hora_atendimento" class="form-label">Hora</label>
                <input type="time" name="hora_atendimento" id="hora_atendimento" class="form-control" value="{{ \Carbon\Carbon::parse($consulta->data_atendimento)->format('H:i') }}" required>
            </div>

            {{-- Valor --}}
            <div class="col-md-6">
                <label for="valor_consulta" class="form-label">Valor</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" step="0.01" name="valor_consulta" id="valor_consulta" class="form-control" value="{{ $consulta->valor_consulta }}" required>
                </div>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Cancelar e Voltar</a>
        </div>

    </form>
@endsection

@section('scripts')
    {{-- jQuery UI Autocomplete --}}
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