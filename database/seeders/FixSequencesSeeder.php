<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixSequencesSeeder extends Seeder
{
    public function run(): void
    {
        // Ajusta sequence da tabela medicos
        DB::statement("SELECT setval('medicos_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM medicos))");

        // Ajusta sequence da tabela pacientes
        DB::statement("SELECT setval('pacientes_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM pacientes))");

        // Ajusta sequence da tabela consultas
        DB::statement("SELECT setval('consultas_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM consultas))");

        // Ajusta sequence da tabela especialidades
        DB::statement("SELECT setval('especialidades_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM especialidades))");

        // Ajusta sequence da tabela tipos_consulta
        DB::statement("SELECT setval('tipos_consulta_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM tipos_consulta))");
    }
}
