@extends('layouts.master')

@section('title', 'Cadastrar Especialidade')

@section('content')
    <h2>Cadastrar Especialidade</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('especialidades.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Especialidade</label>
            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

    </form>
@endsection
