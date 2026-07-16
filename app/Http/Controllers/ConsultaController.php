<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ConsultaController extends Controller
{
    public readonly Consulta $consuta;
    public function __construct(){
        $this->consuta = new Consulta();
    }

    public function index()
    {
        $consutas = $this->consuta->all();
        return view('consultas.index', ['consuta' => $consuta]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('consulta_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created = $this->consuta->create([
            'paciente_id' => $request->input('paciente_id'),
            'medico_id' => $request->input('medico_id'),
            'data_atendimento' => $request->input('data_atendimento'),
            'valor_consulta' => $request->input('valor_consulta')
        ]);
        if ($created) {
            return redirect()->route('consultas.index');
        } else {
            return redirect()->back()->with('message','Error created');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(User $user)
    // {
    //     return view('user_show', ['user'=> $user]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Consulta $consuta)
    // {
    //     return view('user_edit' , ['user'=> $user]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $updated = $this->user->where('id', $id)->update($request->except(['_token', '_method']));
    //     if ($updated) {
    //         return redirect()->back()->with('message','Successfully updated');
    //     } else {
    //         return redirect()->back()->with('message','Error updated');
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     $this->user->where('id', $id)->delete();

    //     return redirect()->route('users.index');
    // }
}
