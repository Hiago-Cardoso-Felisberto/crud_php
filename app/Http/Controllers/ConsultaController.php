<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoConsulta;
use App\Services\ConsultaService;

class ConsultaController extends Controller
{
    protected $consultaService;

    public function __construct(ConsultaService $consultaService){
        $this->consultaService = $consultaService;
    }

    public function index()
    {
        $consultas = $this->consultaService->listarConsultas();
        return view('consultas.index', compact('consultas'));
    }

    public function create()
    {
        $tiposConsulta = $this->consultaService->listarTiposConsulta();
        return view('consultas.create', compact('tiposConsulta'));
    }

    public function store(Request $request)
    {
        $created = $this->consultaService->criarConsulta($request);

        if ($created) {
            return redirect()->route('consultas.index')
                             ->with('success', 'Consulta cadastrada com sucesso!');
        } else {
            return redirect()->back()
                             ->with('error', 'Erro ao cadastrar consulta, tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $updated = $this->consultaService->atualizarConsulta($id, $request);

        if ($updated) {
            return redirect()->route('consultas.index')
                             ->with('success', 'Consulta atualizada com sucesso!');
        } else {
            return redirect()->back()
                             ->with('error', 'Erro ao atualizar consulta.');
        }
    }

    public function destroy($id)
    {
        $deleted = $this->consultaService->deletarConsulta($id);

        if ($deleted) {
            return redirect()->route('consultas.index')
                             ->with('success', 'Consulta removida com sucesso!');
        } else {
            return redirect()->back()
                             ->with('error', 'Erro ao remover consulta.');
        }
    }
}
