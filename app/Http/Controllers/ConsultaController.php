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
        $tiposConsulta = TipoConsulta::all();
        return view('consultas.consulta_create', compact('tiposConsulta'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'tipo_consulta_id' => 'required|exists:tipos_consulta,id',
            'data_atendimento' => 'required|date',
            'hora_atendimento' => 'required|date_format:H:i',
            'valor_consulta' => 'required|numeric|min:0'
        ]);

        $validated['data_atendimento'] = $validated['data_atendimento'] . ' ' . $validated['hora_atendimento'] . ':00';
        unset($validated['hora_atendimento']);

        $created = $this->consultaService->criarConsulta($validated);

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
        $validated = $request->validate([
            'data_atendimento' => 'required|date',
            'hora_atendimento' => 'required|date_format:H:i',
            'valor_consulta' => 'required|numeric|min:0'
        ]);

        $validated['data_atendimento'] = $validated['data_atendimento'] . ' ' . $validated['hora_atendimento'] . ':00';
        unset($validated['hora_atendimento']);

        $updated = $this->consultaService->atualizarConsulta($id, $validated);

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
