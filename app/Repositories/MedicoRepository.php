<?php

namespace App\Repositories;

use App\Models\Medico;

class MedicoRepository
{
    public function all(){
        return Medico::all();
    }

    public function create(array $dadosMedico){
        return Medico::create($dadosMedico);
    }

    public function update($id, array $data){
        return Medico::where('id', $id)->update($data);
    }

    public function delete($id){
        return Medico::where('id', $id)->delete();
    }

    public function search($query)
    {
        return Medico::where('nome', 'LIKE', '%' . $term . '%')->get();
    }

}
