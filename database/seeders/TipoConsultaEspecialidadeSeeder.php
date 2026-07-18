<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoConsultaEspecialidadeSeeder extends Seeder
{
    public function run()
    {
        $relations = [
            ['tipo_consulta_id' => 1, 'especialidade_id' => 3], // Cardiológica ↔ Cardiologia
            ['tipo_consulta_id' => 1, 'especialidade_id' => 1], // Cardiológica ↔ Clínico Geral
            ['tipo_consulta_id' => 2, 'especialidade_id' => 2], // Ortopédica ↔ Ortopedia
            ['tipo_consulta_id' => 3, 'especialidade_id' => 4], // Dermatológica ↔ Dermatologia
            ['tipo_consulta_id' => 4, 'especialidade_id' => 5], // Neurológica ↔ Neurologia
        ];

        foreach ($relations as $rel) {
            DB::table('tipo_consulta_especialidade')->updateOrInsert($rel, $rel);
        }
    }
}
