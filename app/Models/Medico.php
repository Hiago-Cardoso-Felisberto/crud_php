<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = [
        'nome',
        'especialidade_id',
        'crm'
    ];

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
