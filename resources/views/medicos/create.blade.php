@extends('layouts.master')

@section('title', 'Cadastrar Médico')

@section('content')
    <h2>Cadastrar Médico</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Mensagem de erro --}}
    @if ($errors->any())
        <div style="color:red; background-color:#f8d7da; padding:10px; border-radius:5px; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário --}}
   <form action="{{ route('medicos.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" name="crm" id="crm" class="form-control @error('crm') is-invalid @enderror" value="{{ old('crm') }}" required>
                @error('crm')
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

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar e voltar</a>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        const especialidades = @json($especialidades);
        let selecionadas = []; // vazio no create

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
    </script>
@endsection
