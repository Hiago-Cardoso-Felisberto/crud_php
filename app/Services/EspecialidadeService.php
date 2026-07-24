<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Repositories\EspecialidadeRepository;

class EspecialidadeService
{
    protected $repository;

    public function __construct(EspecialidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarEspecialidades()
    {
        return $this->repository->listarEspecialidadesAll();
    }

    public function buscarEspecialidadePorId($id)
    {
        return $this->repository->buscarPorId($id);
    }
    
    public function cadastrarEspecialidade(array $data)
    {
        Validator::make($data, [
            'nome' => 'required|string|max:255|unique:especialidades,nome',
        ])->validate();

        return $this->repository->create($data);
    }

    public function atualizarEspecialidade($id, array $data)
    {
        $tipoConsulta = $this->repository->alterarEspecialidade($id, $data);

        if (isset($data['especialidades'])) {
            $tipoConsulta->especialidades()->sync($data['especialidades']);
        }
        
        return $tipoConsulta;
    }

    public function deletarEspecialidade($id)
    {
        return $this->repository->exclusao($id);
    }

    public function search($query)
    {
        return $this->repository->searchByName($query);
    }
}
