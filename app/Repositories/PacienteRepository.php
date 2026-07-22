<?php

namespace App\Repositories;

use App\Models\Paciente;

class PacienteRepository
{
    protected $paciente;

    public function __construct(Paciente $paciente){
        $this->paciente = $paciente;
    }

    public function listarConsultasAll(){
        return $this->paciente->all();
    }

    public function create(array $pacienteDados){
        unset($pacienteDados['id']);
        return Paciente::create($pacienteDados);
    }

    public function update($id, array $data){
        return $this->paciente->where('id', $id)->update($data);
    }

    public function delete($id){
        return $this->paciente->where('id', $id)->delete();
    }
}
