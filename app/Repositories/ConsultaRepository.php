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

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update($id, array $data){
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id){
        return $this->model->where('id', $id)->delete();
    }
}
