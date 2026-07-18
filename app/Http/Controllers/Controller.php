<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Consulta; 

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
        return view('medicos.index');
    }

    public function pacientes()
    {
        return view('pacientes.index');
    }
}
