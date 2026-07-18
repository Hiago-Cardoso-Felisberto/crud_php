<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Consulta;

class AtendimentoSeeder extends Seeder
{
    public function run()
    {
        // Lê o arquivo JSON
        $json = File::get(database_path('seeders/consul_med_paci.json'));
        $data = json_decode($json, true);

        // Insere pacientes
        foreach ($data['pacientes'] as $paciente) {
            Paciente::updateOrCreate(
                ['id' => $paciente['id']],
                $paciente
            );
        }

        // Insere médicos
        foreach ($data['medicos'] as $medico) {
            $especialidade = \App\Models\Especialidade::where('nome', $medico['especialidade'])->first();

            Medico::updateOrCreate(
                ['id' => $medico['id']],
                [
                    'nome' => $medico['nome'],
                    'crm' => $medico['crm'],
                    'especialidade_id' => $especialidade->id ?? null
                ]
            );
        }

        // Insere consultas
        foreach ($data['consultas'] as $consulta) {
            Consulta::updateOrCreate(
                ['id' => $consulta['id']],
                $consulta
            );
        }
    }
}
