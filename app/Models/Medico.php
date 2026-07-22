<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = [
        'nome',
        'crm'
    ];

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'medico_especialidade');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}

