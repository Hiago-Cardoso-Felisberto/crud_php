<?php

namespace App\Services;

use App\Repositories\PacienteRepository;
use Illuminate\Support\Facades\Validator;

class PacienteService
{
    protected $pacienteRepository;

    public function __construct(PacienteRepository $pacienteRepository){
        $this->pacienteRepository = $pacienteRepository;
    }

    public function listarConsultas(){
        return $this->pacienteRepository->listarConsultasAll();
    }

    public function cadastrarPaciente(array $pacienteDados){

        $pacienteDados['data_nascimento'] = \Carbon\Carbon::parse($pacienteDados['data_nascimento'])->format('Y-m-d');

        Validator::make($pacienteDados, [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|unique:pacientes,cpf',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
        ])->validate();

        return $this->pacienteRepository->create($pacienteDados);
    }

    public function atualizarPaciente($id, array $data){
        return $this->pacienteRepository->update($id, $data);
    }

    public function excluirPaciente($id){
        return $this->pacienteRepository->delete($id);
    }
}
