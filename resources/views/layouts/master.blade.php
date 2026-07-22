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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00'); 
            
            // Telefone dinâmico: celular (11 dígitos) ou fixo (10 dígitos)
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
                
                // remove a máscara e deixa só os números
                var cpfLimpo = $('#cpf').cleanVal();
                var telefoneLimpo = $('#telefone').cleanVal();

                $('#cpf').val(cpfLimpo);
                $('#telefone').val(telefoneLimpo);
            });

        });
    </script>
</body>
</html>
