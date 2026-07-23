@extends('layouts.master')

@section('title', 'Editar Tipo de Consulta')

@section('content')
    <h2>Editar Tipo de Consulta</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('tipos_consulta.update', ['tipoConsulta' => $tipoConsulta->id]) }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $tipoConsulta->nome) }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="duracao" class="form-label">Duração (minutos)</label>
                <input type="number" name="duracao" id="duracao" class="form-control @error('duracao') is-invalid @enderror" value="{{ old('duracao', $tipoConsulta->duracao) }}" required>
                @error('duracao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="especialidade" class="form-label">Especialidades</label>
                <input type="text" id="especialidade" class="form-control @error('especialidades') is-invalid @enderror" placeholder="Digite para buscar...">
                <div id="selecionadas" class="mt-2 d-flex flex-wrap gap-2"></div>
                <input type="hidden" name="especialidades" id="especialidades_hidden">
                @error('especialidades')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="hora_inicio" class="form-label">Hora Início</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old('hora_inicio', $tipoConsulta->hora_inicio) }}" required>
                @error('hora_inicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="hora_fim" class="form-label">Hora Fim</label>
                <input type="time" name="hora_fim" id="hora_fim" class="form-control @error('hora_fim') is-invalid @enderror" value="{{ old('hora_fim', $tipoConsulta->hora_fim) }}" required>
                @error('hora_fim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('tipos_consulta.index') }}" class="btn btn-secondary">Cancelar e voltar</a>
        </div>

    </form>
@endsection

@section('scripts')
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
