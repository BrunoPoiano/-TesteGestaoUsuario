<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioridadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prioridades')->insert([
            'nome' => 'Familia',
        ]);
        DB::table('prioridades')->insert([
            'nome' => 'Trabalho',
        ]);
        DB::table('prioridades')->insert([
            'nome' => 'Faculdade',
        ]);
    }
}
