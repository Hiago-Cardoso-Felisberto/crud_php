@extends('layouts.master')

@section('title', 'Editar Médico')

@section('content')
    <h2>Editar Médico</h2>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Formulário --}}
    <form action="{{ route('medicos.store', ['medico' => $medico->id])}}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label for="nome">Nome:</label><br>
            <input type="text" name="nome" id="nome" value="{{ $medico->nome }}" required>
            @error('nome') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="crm">CRM:</label><br>
            <input type="text" name="crm" id="crm" value="{{ $medico->nome }}" required>
            @error('crm') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="especialidade">Especialidade:</label><br>
            <input type="text" id="especialidade" placeholder="Digite para buscar..." autocomplete="off">
            <input type="hidden" name="especialidade_id" id="especialidade_id">
            @error('especialidade_id') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" 
                style="padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px;">
            Salvar
        </button>
    </form>

    {{-- Script de autocomplete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('especialidade');
            const hidden = document.getElementById('especialidade_id');

            input.addEventListener('input', function () {
                fetch(`/especialidades/search?query=${input.value}`)
                    .then(response => response.json())
                    .then(data => {
                        // Remove sugestões antigas
                        let list = document.getElementById('esp-list');
                        if (list) list.remove();

                        // Cria lista de sugestões
                        list = document.createElement('ul');
                        list.id = 'esp-list';
                        list.style.border = '1px solid #ccc';
                        list.style.position = 'absolute';
                        list.style.background = '#fff';
                        list.style.listStyle = 'none';
                        list.style.padding = '0';
                        list.style.margin = '0';
                        list.style.width = input.offsetWidth + 'px';

                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = item.nome;
                            li.style.padding = '5px';
                            li.style.cursor = 'pointer';
                            li.addEventListener('click', () => {
                                input.value = item.nome;
                                hidden.value = item.id;
                                list.remove();
                            });
                            list.appendChild(li);
                        });

                        input.parentNode.appendChild(list);
                    });
            });
        });
    </script>
@endsection
