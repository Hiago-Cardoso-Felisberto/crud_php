<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = [
        'nome',
        'especialidade',
        'crm'
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
