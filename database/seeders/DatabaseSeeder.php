<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    // Vai chamar a classe que inseri os dados iniciais no banco
    public function run()
    {
        $this->call(AtendimentoSeeder::class);
    }
}
