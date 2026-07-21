<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Consultas')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1; /* ocupa todo o espaço disponível */
            padding: 20px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="{{ url('/') }}" style="color:white; text-decoration:none;">Home</a>
        </div>
        <nav>
            <a href="{{ route('consultas.index') }}">Consultas</a>
            <a href="{{ route('medicos.index') }}">Médicos</a>
            <a href="{{ route('pacientes.index') }}">Pacientes</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} - Sistema de Consultas</p>
    </footer>

    @yield('scripts')
</body>
</html>
