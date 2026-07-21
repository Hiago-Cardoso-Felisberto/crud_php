<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TipoConsultaService;
use App\Models\TipoConsulta;
use App\Models\Especialidade;

class TipoConsultaController extends Controller
{
    protected $service;

    public function __construct(TipoConsultaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $tipos = $this->service->listarTiposConsulta();
        return view('tipos_consulta.index', compact('tipos'));
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        return view('tipos_consulta.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $this->service->cadastrarTipoConsulta($request->all());
        return redirect()->route('tipos_consulta.index')->with('success', 'Tipo de consulta cadastrado com sucesso!');
    }

    public function edit(TipoConsulta $tipoConsulta)
    {
        $especialidades = Especialidade::all();
        return view('tipos_consulta.edit', compact('tipoConsulta','especialidades'));
    }

    public function update(Request $request, $id)
    {
        $this->service->atualizarTipoConsulta($id, $request->except(['_token', '_method']));
        return redirect()->route('tipos_consulta.index')->with('success','Tipo de consulta atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->service->deletarTipoConsulta($id);
        return redirect()->route('tipos_consulta.index')->with('success','Tipo de consulta excluído com sucesso!');
    }

}
