<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
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
        try {
            $created = $this->consultaService->criarConsulta($request->all());

            if ($created) {
                return redirect()->route('consultas.index')
                                 ->with('success', 'Consulta cadastrada com sucesso!');
            } else {
                return redirect()->back()
                                 ->with('error', 'Erro ao cadastrar consulta, tente novamente.')
                                 ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Erro: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function edit(Consulta $consulta)
    {
        $tiposConsulta = $this->consultaService->listarTiposConsulta();
        return view('consultas.edit', compact('consulta', 'tiposConsulta'));
    }

    public function update(Request $request, $id)
    {
        try {
            $updated = $this->consultaService->atualizarConsulta($id, $request->all());

            if ($updated) {
                return redirect()->route('consultas.index')
                                 ->with('success', 'Consulta atualizada com sucesso!');
            } else {
                return redirect()->back()
                                 ->with('error', 'Erro ao atualizar consulta.')
                                 ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Erro: ' . $e->getMessage())
                             ->withInput();
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

    public function medicosPorTipo($tipoConsultaId){
        $medicos = $this->consultaService->buscarMedico($tipoConsultaId);
        return response()->json($medicos);
    }

}
