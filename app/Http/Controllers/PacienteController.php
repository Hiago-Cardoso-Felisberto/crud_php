<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PacienteService;
use App\Models\Paciente;

class PacienteController extends Controller
{
    protected $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    public function index()
    {
        return view('pacientes.index');
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        try {

            $this->pacienteService->cadastrarPaciente($request->all());

            return redirect()
                ->route('pacientes.index')
                ->with('success', 'Paciente cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao salvar paciente: ' . $e->getMessage()])
                ->withInput(); // mantém os dados preenchidos
        }
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit' , compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->pacienteService->atualizarPaciente($id, $request->except(['_token', '_method']));
            return redirect()->route('pacientes.index')->with('success','Paciente atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao atualizar paciente: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $this->pacienteService->excluirPaciente($id);
        return redirect()->route('pacientes.index')->with('success','Paciente excluído com sucesso!');
    }

    public function buscar(Request $request)
    {
        $term = $request->get('term');
        $pacientes = Paciente::where('nome', 'LIKE', '%' . $term . '%')->get();

        return response()->json($pacientes);
    }
}
