<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EspecialidadeService;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    protected $service;

    public function __construct(EspecialidadeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $especialidades = $this->service->listarEspecialidades();
        return view('especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $this->service->cadastrarEspecialidade($request->all());
        return redirect()->route('especialidades.index')->with('success', 'Especialidade cadastrada com sucesso!');
    }

    public function edit(Especialidade $especialidade)
    {
        return view('especialidades.edit', compact('especialidade'));
    }

    public function update(Request $request, $id)
    {
        $this->service->atualizarEspecialidade($id, $request->except(['_token', '_method']));
        return redirect()->route('especialidades.index')->with('success','Especialidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $this->service->deletarEspecialidade($id);
        return redirect()->route('especialidades.index')->with('success','Especialidade excluída com sucesso!');
    }

    public function search(Request $request)
    {
        return $this->service->search($request->get('query'));
    }
}
