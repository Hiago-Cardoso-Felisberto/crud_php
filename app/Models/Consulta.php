<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'data_atendimento',
        'valor_consulta'
    ];

    protected $casts = [
        'data_atendimento' => 'datetime',
        'valor_consulta' => 'decimal:2'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
