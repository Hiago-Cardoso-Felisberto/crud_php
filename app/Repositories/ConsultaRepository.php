<?php

namespace App\Repositories;

use App\Models\Consulta;
use App\Models\TipoConsulta;

class ConsultaRepository
{
    protected $model;

    public function __construct(Consulta $consulta){
        $this->model = $consulta;
    }

    public function all()
    {
        return $this->model->with(['paciente', 'medico'])
                            ->orderBy('data_atendimento', 'desc')
                            ->get();
    }

    public function TipoConsultaAll()
    {
        return TipoConsulta::all();
    }

    public function create(array $dadosCunsulta){
        unset($dadosCunsulta['id']);
        return $this->model->create($dadosCunsulta);
    }

    public function update($id, array $data){
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id){
        return $this->model->where('id', $id)->delete();
    }

    public function medicosPorTipoConsulta($id){
        $tipo = TipoConsulta::with('especialidades.medicos')->findOrFail($id);
        return $tipo->especialidades->flatMap->medicos->unique('id')->values();
    }
}
