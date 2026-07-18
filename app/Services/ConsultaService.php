<?php

namespace App\Services;

use App\Repositories\ConsultaRepository;

class ConsultaService
{
    protected $consultaRepository;

    public function __construct(ConsultaRepository $consultaRepository){
        $this->consultaRepository = $consultaRepository;
    }

    public function listarConsultas(){
        return $this->consultaRepository->all();
    }

    public function criarConsulta(array $data){
        
        return $this->consultaRepository->create($data);
    }

    public function atualizarConsulta($id, array $data){
        return $this->consultaRepository->update($id, $data);
    }

    public function deletarConsulta($id){
        return $this->consultaRepository->delete($id);
    }
}
