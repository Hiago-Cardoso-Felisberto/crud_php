<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\TipoConsultaRepository;

class TipoConsultaService
{
    protected $repository;

    public function __construct(TipoConsultaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarTiposConsulta()
    {
        return $this->repository->listarTiposConsultasAll();
    }

    public function cadastrarTipoConsulta(array $data)
    {
        Validator::make($data, [
            'nome' => 'required|string|max:255|unique:tipos_consulta,nome',
            'duracao' => 'required|integer|min:5', // já garante mínimo de 5
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'especialidades' => 'required|string', // vem como string "1,3,5"
        ])->validate();

        $tipoConsulta = $this->repository->create($data);

        // transforma string em array
        $especialidades = explode(',', $data['especialidades']);
        $tipoConsulta->especialidades()->sync($especialidades);

        return $tipoConsulta;
    }

    public function atualizarTipoConsulta($id, array $data)
    {
        Validator::make($data, [
            'nome' => 'required|string|max:255|unique:tipos_consulta,nome,' . $id,
            'duracao' => 'required|integer|min:5',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'especialidades' => 'nullable|string',
        ])->validate();

        $tipoConsulta = $this->repository->alterarTipoConsulta($id, $data);

        if (isset($data['especialidades'])) {
            $especialidades = explode(',', $data['especialidades']);
            $tipoConsulta->especialidades()->sync($especialidades);
        }

        return $tipoConsulta;
    }

    public function deletarTipoConsulta($id)
    {
        return $this->repository->exclusao($id);
    }
}
