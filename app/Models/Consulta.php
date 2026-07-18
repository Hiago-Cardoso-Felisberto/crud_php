<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'tipo_consulta_id',
        'data_atendimento',
        'valor_consulta'
    ];

    protected $casts = [
        'data_atendimento' => 'datetime',
    ];

    public function tipoConsulta()
    {
        return $this->belongsTo(TipoConsulta::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
