<?php

namespace App\Repositories;

use App\Models\Especialidade;

class EspecialidadeRepository
{

    public function listarEspecialidadesAll()
    {
        return Especialidade::all();
    }

    public function create(array $data)
    {
        return Especialidade::create($data);
    }

    public function alterarEspecialidade($id, array $data)
    {
        $tipo = Especialidade::findOrFail($id);
        $tipo->update($data);
        return $tipo;
    }

    public function exclusao($id)
    {
        $tipo = Especialidade::findOrFail($id);
        return $tipo->delete();
    }

    public function searchByName($query)
    {
        return Especialidade::where('nome', 'LIKE', "%{$query}%")->get(['id', 'nome']);
    }
}
