<?php

namespace App\Services;

use App\Repositories\ConsultaRepository;

class ConsultaService
{
    protected $consultaRepository;

    public function __construct(ConsultaRepository $consultaRepository){
        $this->consultaRepository = $consultaRepository;
    }

    public function listarConsultas(){
        return $this->consultaRepository->all();
    }

    public function listarTiposConsulta()
    {
        return $this->tipoConsultaRepository->TipoConsultaAll();
    }

    public function criarConsulta(array $dadosCunsulta){
        
        Validator::make($dadosCunsulta, [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'tipo_consulta_id' => 'required|exists:tipos_consulta,id',
            'data_atendimento' => 'required|date',
        ])->validate();

        $tipoConsulta = TipoConsulta::find($dadosCunsulta['tipo_consulta_id']);
        $medico = Medico::find($dadosCunsulta['medico_id']);

        // Verifica se médico atende o tipo de consulta
        if (!$tipoConsulta->especialidades->contains($medico->especialidade_id)) {
            throw ValidationException::withMessages([
                'medico_id' => 'Este médico não atende este tipo de consulta.'
            ]);
        }

        // Verifica se horário está dentro da janela
        $hora = date('H:i', strtotime($dadosCunsulta['data_atendimento']));
        if ($hora < $tipoConsulta->hora_inicio || $hora > $tipoConsulta->hora_fim) {
            throw ValidationException::withMessages([
                'data_atendimento' => 'Horário fora da janela permitida para este tipo de consulta.'
            ]);
        }

        return $this->consultaRepository->create($dadosCunsulta);
    }

    public function atualizarConsulta($id, array $data){

         $validated = $data->validate([
            'data_atendimento' => 'required|date',
            'hora_atendimento' => 'required|date_format:H:i',
            'valor_consulta' => 'required|numeric|min:0'
        ]);

        $validated['data_atendimento'] = $validated['data_atendimento'] . ' ' . $validated['hora_atendimento'] . ':00';
        unset($validated['hora_atendimento']);

        return $this->consultaRepository->update($id, $validated);
    }

    public function deletarConsulta($id){
        return $this->consultaRepository->delete($id);
    }
}
