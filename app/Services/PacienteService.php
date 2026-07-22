<?php

namespace App\Services;

use App\Repositories\PacienteRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

        $dataNascimento = \Carbon\Carbon::parse($pacienteDados['data_nascimento']);
        if ($dataNascimento->isFuture()) {
            throw ValidationException::withMessages([
                'data_nascimento' => 'A data de nascimento deve ser o dia atual ou menor.'
            ]);
        }

        try {
            return $this->pacienteRepository->create($pacienteDados);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23505') {
                // erro de chave duplicada.
                throw new \Exception('Já existe um paciente com esse CPF.');
            }
            throw $e; // outros erros.
        }
    }

    public function atualizarPaciente($id, array $data){
        try {
            Validator::make($data, [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|unique:pacientes,cpf,' . $id,
                'data_nascimento' => 'required|date',
                'telefone' => 'required|string|max:20',
            ])->validate();

            $dataNascimento = \Carbon\Carbon::parse($data['data_nascimento']);
            if ($dataNascimento->isFuture()) {
                throw ValidationException::withMessages([
                    'data_nascimento' => 'A data de nascimento deve ser o dia atual ou menor.'
                ]);
            }

            return $this->pacienteRepository->update($id, $data);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'cpf') !== false) {
                throw new \Exception('Já existe um paciente com esse CPF.');
            }
            throw $e;
        }
    }

    public function excluirPaciente($id){
        return $this->pacienteRepository->delete($id);
    }
}
