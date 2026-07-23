<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ConsultaRepository;
use App\Models\TipoConsulta;
use App\Models\Medico;
use App\Models\Consulta;
use Carbon\Carbon;

class ConsultaService
{
    protected $consultaRepository;

    public function __construct(ConsultaRepository $consultaRepository){
        $this->consultaRepository = $consultaRepository;
    }

    public function listarConsultas()
    {
        return $this->consultaRepository->all();
    }

    public function listarTiposConsulta(){
        return $this->consultaRepository->TipoConsultaAll();
    }

    public function criarConsulta(array $dadosConsulta){
        Validator::make($dadosConsulta, [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'tipo_consulta_id' => 'required|exists:tipos_consulta,id',
            'data_atendimento' => 'required|date',
            'hora_atendimento' => 'required|date_format:H:i',
            'valor_consulta' => 'required|numeric|min:0'
        ])->validate();

        $dadosConsulta['data_atendimento'] = $dadosConsulta['data_atendimento'] . ' ' . $dadosConsulta['hora_atendimento'] . ':00';
        unset($dadosConsulta['hora_atendimento']);

        $this->validarConsulta($dadosConsulta);

        return $this->consultaRepository->create($dadosConsulta);
    }

    public function atualizarConsulta($id, array $data){
        Validator::make($data, [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'tipo_consulta_id' => 'required|exists:tipos_consulta,id',
            'data_atendimento' => 'required|date',
            'hora_atendimento' => 'required|date_format:H:i',
            'valor_consulta' => 'required|numeric|min:0'
        ])->validate();

        // Combina data + hora
        $data['data_atendimento'] = $data['data_atendimento'] . ' ' . $data['hora_atendimento'] . ':00';
        unset($data['hora_atendimento']);

        // Remove campos extras que não existem na tabela
        unset($data['_token'], $data['_method'], $data['paciente_nome']);

        // Aplica todas as validações de negócio
        $this->validarConsulta($data, $id);

        return $this->consultaRepository->update($id, $data);
    }

    public function deletarConsulta($id){
        return $this->consultaRepository->delete($id);
    }

    public function buscarMedico($tipoConsultaId){
        return $this->consultaRepository->medicosPorTipoConsulta($tipoConsultaId);
    }

    private function validarConsulta(array $dadosConsulta, $id = null){
        $tipoConsulta = TipoConsulta::find($dadosConsulta['tipo_consulta_id']);
        $medico = Medico::find($dadosConsulta['medico_id']);

        // Data futura
        $dataAtendimento = Carbon::parse($dadosConsulta['data_atendimento']);
        if (!$dataAtendimento->isFuture()) {
            throw ValidationException::withMessages([
                'data_atendimento' => 'A data e hora da consulta devem ser posteriores ao momento atual.'
            ]);
        }

        // Conflito de horário (ignora a própria consulta no update)
        $inicio = $dataAtendimento;
        $fim = $inicio->copy()->addMinutes($tipoConsulta->duracao);

        $consultaConflitante = Consulta::where('medico_id', $dadosConsulta['medico_id'])
            ->when($id, fn($q) => $q->where('id', '!=', $id))
            ->get()
            ->contains(function($consulta) use ($inicio, $fim) {
                $consultaInicio = Carbon::parse($consulta->data_atendimento);
                $consultaFim = $consultaInicio->copy()->addMinutes($consulta->tipoConsulta->duracao);
                return $inicio->between($consultaInicio, $consultaFim) || $fim->between($consultaInicio, $consultaFim);
            });

        if ($consultaConflitante) {
            throw ValidationException::withMessages([
                'data_atendimento' => 'Este médico já possui uma consulta neste horário.'
            ]);
        }

        // Janela de horário
        $horaConsulta = $dataAtendimento->format('H:i');
        $horaInicio = Carbon::parse($tipoConsulta->hora_inicio)->format('H:i');
        $horaFim = Carbon::parse($tipoConsulta->hora_fim)->format('H:i');

        if ($horaConsulta < $horaInicio || $horaConsulta > $horaFim) {
            throw ValidationException::withMessages([
                'data_atendimento' => 'Horário fora da janela permitida para este tipo de consulta. '
                    . 'Horário permitido: Início: ' . $horaInicio . ', Fim: ' . $horaFim
            ]);
        }

        // Especialidades
        $especialidadesMedico = $medico->especialidades->pluck('id');
        if (!$tipoConsulta->especialidades->pluck('id')->intersect($especialidadesMedico)->count()) {
            throw ValidationException::withMessages([
                'medico_id' => 'Este médico não atende este tipo de consulta.'
            ]);
        }
    }
}
