@extends('layouts.master')

@section('title', 'Editar Tipo de Consulta')

@section('content')
    <h2>Editar Tipo de Consulta</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('tipos_consulta.update', ['tipoConsulta' => $tipoConsulta->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label for="nome">Nome:</label><br>
            <input type="text" name="nome" id="nome" value="{{ $tipoConsulta->nome }}" required>
            @error('nome') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="especialidade">Especialidades:</label><br>
            <input type="text" id="especialidade" placeholder="Digite para buscar...">
            <div id="selecionadas" style="margin-top:10px;"></div>
            <input type="hidden" name="especialidades" id="especialidades_hidden">
            @error('especialidades') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="duracao">Duração (minutos):</label><br>
            <input type="number" name="duracao" id="duracao" value="{{ $tipoConsulta->duracao }}" required>
            @error('duracao') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="hora_inicio">Hora Início:</label><br>
            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ $tipoConsulta->hora_inicio }}" required>
            @error('hora_inicio') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="hora_fim">Hora Fim:</label><br>
            <input type="time" name="hora_fim" id="hora_fim" value="{{ $tipoConsulta->hora_fim }}" required>
            @error('hora_fim') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">Salvar</button>

        <a href="{{ route('tipos_consulta.index') }}" 
        style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
        Cancelar e voltar
        </a>
    </form>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
    const especialidades = @json($especialidades);
    let selecionadas = @json($tipoConsulta->especialidades->pluck('id')); // já populadas

    // Autocomplete
    $("#especialidade").autocomplete({
        source: especialidades.map(e => e.nome),
        select: function(event, ui) {
            const esp = especialidades.find(e => e.nome === ui.item.value);
            if (esp && !selecionadas.includes(esp.id)) {
                selecionadas.push(esp.id);
                renderSelecionadas();
                $("#especialidades_hidden").val(selecionadas.join(','));
            }
            $(this).val('');
            return false;
        }
    });

    // Render chips
    function renderSelecionadas() {
        $("#selecionadas").empty();
        selecionadas.forEach(id => {
            const esp = especialidades.find(e => e.id === id);
            const chip = $("<span>")
                .text(esp.nome)
                .css({
                    display: "inline-block",
                    margin: "5px",
                    padding: "5px",
                    background: "#3498db",
                    color: "white",
                    borderRadius: "5px",
                    cursor: "pointer"
                })
                .click(() => {
                    selecionadas = selecionadas.filter(s => s !== id);
                    renderSelecionadas();
                    $("#especialidades_hidden").val(selecionadas.join(','));
                });
            $("#selecionadas").append(chip);
        });
        $("#especialidades_hidden").val(selecionadas.join(','));
    }

    // inicializa chips já vinculados
    renderSelecionadas();
</script>
@endsection
