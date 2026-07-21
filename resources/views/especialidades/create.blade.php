@extends('layouts.master')

@section('title', 'Cadastrar Especialidade')

@section('content')
    <h2>Cadastrar Especialidade</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('especialidades.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:15px;">
            <label for="nome">Nome da Especialidade:</label><br>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
            @error('nome') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">Salvar</button>

         {{-- Botão de voltar --}}
        <a href="{{ route('especialidades.index') }}" 
        style="display:inline-block; margin-top:15px; padding:9px; background:#7f8c8d; color:white; text-decoration:none; border-radius:5px;">
        Voltar
        </a>
        
    </form>
@endsection
