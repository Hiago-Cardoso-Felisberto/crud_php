@extends('layouts.master')

@section('title', 'Alteração de paciente')

@section('content')

    <h2>Editar Paciente</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <form action="{{ route('pacientes.update', ['paciente' => $paciente->id]) }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label for="nome" class="form-label">Nome do paciente</label>
                <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $paciente->nome) }}">
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control @error('cpf') is-invalid @enderror" value="{{ old('cpf', $paciente->cpf) }}">
                @error('cpf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="data_nascimento" class="form-label">Data de nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror" value="{{ old('data_nascimento', \Carbon\Carbon::parse($paciente->data_nascimento)->format('Y-m-d')) }}" required>
                @error('data_nascimento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone / Celular</label>
                <input type="text" name="telefone" id="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone', $paciente->telefone) }}" required>
                @error('telefone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar e voltar</a>
        </div>

    </form>
   
@endsection

@section('scripts')
    <script>
    $(document).ready(function(){
            $('#cpf').mask('000.000.000-00'); 
            
            var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            };

            var spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

            $('#telefone').mask(SPMaskBehavior, spOptions);

            $('form').on('submit', function(){
                var cpfLimpo = $('#cpf').cleanVal();
                var telefoneLimpo = $('#telefone').cleanVal();

                $('#cpf').val(cpfLimpo);
                $('#telefone').val(telefoneLimpo);
            });
        });
    </script>
@endsection

