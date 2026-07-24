<?php

namespace App\Repositories;

use App\Models\TipoConsulta;

class TipoConsultaRepository
{
    public function listarTiposConsultasAll()
    {
        return TipoConsulta::all();
    }

    public function buscarPorId($id)
    {
        return TipoConsulta::find($id);
    }

    public function create(array $data)
    {
        unset($data['id']);
        return TipoConsulta::create($data);
    }

    public function alterarTipoConsulta($id, array $data)
    {
        $tipo = TipoConsulta::findOrFail($id);
        $tipo->update($data);
        return $tipo;
    }

    public function exclusao($id)
    {
        $tipo = TipoConsulta::findOrFail($id);
        return $tipo->delete();
    }


}
