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
        foreach ($data['medicos'] as $medicoData) {
            $especialidade = \App\Models\Especialidade::where('nome', $medicoData['especialidade'])->first();

            // Cria ou atualiza médico sem especialidade_id
            $medico = Medico::updateOrCreate(
                ['id' => $medicoData['id']],
                ['nome' => $medicoData['nome'], 'crm' => $medicoData['crm']]
            );

            // Vincula especialidade na pivot
            if ($especialidade) {
                $medico->especialidades()->syncWithoutDetaching([$especialidade->id]);
            }
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
