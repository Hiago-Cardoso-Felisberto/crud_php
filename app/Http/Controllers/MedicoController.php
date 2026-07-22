<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Especialidade;
use App\Services\MedicoService;

class MedicoController extends Controller
{
    protected $service;

    public function __construct(MedicoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $medicos = $this->service->listarMedicos();
        return view('medicos.index', compact('medicos'));
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        return view('medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        try {
            $this->service->cadastrarMedico($request->all());
            return redirect()->route('medicos.index')->with('success', 'Medico cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao salvar médico: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Medico $medico)
    {
        $especialidades = Especialidade::all();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->service->atualizarMedicos($id, $request->except(['_token', '_method']));
            return redirect()->route('medicos.index')->with('success','Medico atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao atualizar médico: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $this->service->deletarMedicos($id);
        return redirect()->route('medicos.index')->with('success','Medico excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $result = $this->service->buscar($request->get('query'));
        return response()->json($result);
    }
}
