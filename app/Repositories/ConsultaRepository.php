<?php

namespace App\Repositories;

use App\Models\Consulta;

class ConsultaRepository
{
    protected $model;

    public function __construct(Consulta $consulta){
        $this->model = $consulta;
    }

    public function all(){
        return $this->model->all();
    }

    public function TipoConultaAll()
    {
        return TipoConsulta::all();
    }

    public function create(array $dadosCunsulta){
        return $this->model->create($dadosCunsulta);
    }

    public function update($id, array $data){
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id){
        return $this->model->where('id', $id)->delete();
    }
}
