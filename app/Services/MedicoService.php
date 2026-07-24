<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MedicoRepository;
use App\Models\Medico;

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

    public function buscarMedicoPorId($id){
        return $this->repository->buscarPorId($id);
    }

    public function cadastrarMedico(array $dadosMedico)
    {
        Validator::make($dadosMedico, [
            'nome' => 'required|string|max:255',
            'crm' => 'required|unique:medicos,crm',
            'especialidades' => 'required'
        ])->validate();

        try {
            // Extrai IDs das especialidades
            $especialidades = explode(',', $dadosMedico['especialidades']);
            unset($dadosMedico['especialidades']);

            // Cria médico
            $medico = $this->repository->create($dadosMedico);

            // Vincula especialidades na pivot
            $medico->especialidades()->sync($especialidades);

            return $medico;
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'crm') !== false) {
                throw new \Exception('Já existe um médico com esse CRM.');
            }
            throw $e;
        }
    }

    public function atualizarMedicos($id, array $data)
    {
        Validator::make($data, [
            'nome' => 'required|string|max:255',
            'crm' => 'required|unique:medicos,crm,' . $id,
            'especialidades' => 'required'
        ])->validate();

        try {
            // Extrai IDs das especialidades
            $especialidades = explode(',', $data['especialidades']);
            unset($data['especialidades']);

            // Busca médico
            $medico = Medico::findOrFail($id);

            // Atualiza dados básicos
            $medico->update($data);

            // Atualiza pivot
            $medico->especialidades()->sync($especialidades);

            return $medico;
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'crm') !== false) {
                throw new \Exception('Já existe um médico com esse CRM.');
            }
            throw $e;
        }
    }

    public function deletarMedicos($id){
        return $this->repository->delete($id);
    }

    public function buscar($query)
    {
        return $this->repository->search($query);
    }
}
