<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidade;

class EspecialidadesSeeder extends Seeder
{
    public function run()
    {
        $especialidades = [
            ['nome' => 'Clínico Geral'],
            ['nome' => 'Ortopedia'],
            ['nome' => 'Cardiologia'],
            ['nome' => 'Dermatologia'],
            ['nome' => 'Neurologia'],
        ];

        foreach ($especialidades as $esp) {
            Especialidade::updateOrCreate(['nome' => $esp['nome']], $esp);
        }
    }
}
