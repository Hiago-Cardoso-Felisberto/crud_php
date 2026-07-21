<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
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
        return view('medicos.create');
    }

    public function store(Request $request)
    {
        $this->service->cadastrarMedico($request->all());
        return redirect()->route('medicos.index')->with('success', 'Medico cadastrado com sucesso!');
    }

    public function edit(Medicos $medicos)
    {
        return view('medicos.edit', compact('medicos'));
    }

    public function update(Request $request, $id)
    {
        $this->service->atualizarMedicos($id, $request->except(['_token', '_method']));
        return redirect()->route('medicos.index')->with('success','Medico atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->service->deletarMedicos($id);
        return redirect()->route('medicos.index')->with('success','Medico excluído com sucesso!');
    }

    public function search(Request $request)
    {
        return $this->service->buscar($request->get('query'));
    }
}
