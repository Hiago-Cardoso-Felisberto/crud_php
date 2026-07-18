<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    protected $table = 'tipos_consulta';

    protected $fillable = [
        'nome',
        'duracao',
        'hora_inicio',
        'hora_fim'
    ];

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'tipo_consulta_especialidade');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
