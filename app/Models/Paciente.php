<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'telefone'
    ];

    protected $casts = [
        'data_nascimento' => 'date'
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
