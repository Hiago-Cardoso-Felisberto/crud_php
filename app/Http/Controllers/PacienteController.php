<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pacientes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pacientes.pacientes_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|unique:pacientes,cpf',
                'data_nascimento' => 'required|date',
                'telefone' => 'nullable|string|max:20',
            ]);

            Paciente::create($validated);

            return redirect()
                ->route('pacientes.index')
                ->with('message', 'Paciente cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao salvar paciente: ' . $e->getMessage()])
                ->withInput(); // mantém os dados preenchidos
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user_show', ['user'=> $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user_edit' , ['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updated = $this->user->where('id', $id)->update($request->except(['_token', '_method']));
        if ($updated) {
            return redirect()->back()->with('message','Successfully updated');
        } else {
            return redirect()->back()->with('message','Error updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->user->where('id', $id)->delete();

        return redirect()->route('users.index');
    }

    public function buscar(Request $request)
    {
        $term = $request->get('term');
        $pacientes = Paciente::where('nome', 'LIKE', '%' . $term . '%')->get();

        return response()->json($pacientes);
    }
}
