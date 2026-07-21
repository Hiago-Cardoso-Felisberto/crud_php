<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MedicoRepository;

class MedicoService
{
    protected $repository;

    public function __construct(MedicoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarMedicos(){
        return $this->repository->all();
    }

    public function cadastrarMedico(array $dadosMedico)
    {
        Validator::make($dadosMedico, [
            'nome' => 'required|string|max:255',
            'crm' => 'required|unique:medicos,crm',
            'especialidade_id' => 'required|exists:especialidades,id',
        ])->validate();

        return $this->repository->create($dadosMedico);
    }

    public function atualizarMedicos($id, array $data){
        return $this->repository->update($id, $data);
    }

    public function deletarMedicos($id){
        return $this->repository->delete($id);
    }

    public function buscar($query)
    {
        return $this->repository->search($query);
    }
}
