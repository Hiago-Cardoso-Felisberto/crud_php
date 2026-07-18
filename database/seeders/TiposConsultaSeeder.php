<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoConsulta;

class TiposConsultaSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['nome' => 'Consulta Cardiológica', 'duracao' => 30, 'hora_inicio' => '08:00', 'hora_fim' => '18:00'],
            ['nome' => 'Consulta Ortopédica', 'duracao' => 45, 'hora_inicio' => '09:00', 'hora_fim' => '17:00'],
            ['nome' => 'Consulta Dermatológica', 'duracao' => 30, 'hora_inicio' => '10:00', 'hora_fim' => '16:00'],
            ['nome' => 'Consulta Neurológica', 'duracao' => 50, 'hora_inicio' => '08:30', 'hora_fim' => '15:30'],
        ];

        foreach ($tipos as $tipo) {
            TipoConsulta::updateOrCreate(['nome' => $tipo['nome']], $tipo);
        }
    }
}
