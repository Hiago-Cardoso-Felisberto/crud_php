<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Consulta; 
use App\Models\Medico; 
use App\Models\Paciente; 

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('home');
    }

    public function consultas()
    {
        $consultas = Consulta::all();
        return view('consultas.index', ['consultas' => $consultas]);
    }

    public function medicos()
    {
        $medicos = Medico::all();
        return view('medicos.index', ['medicos' => $medicos]);
    }

    public function pacientes()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', ['pacientes' => $pacientes]);
    }
}
