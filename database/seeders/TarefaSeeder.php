<?php

namespace Database\Seeders;

use App\Models\Tarefa\Tarefa;
use Illuminate\Database\Seeder;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarefa::factory()->count(10)->create();
    }
}
