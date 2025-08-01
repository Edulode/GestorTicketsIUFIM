<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asunto;
use Illuminate\Support\Facades\DB;

class AsuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asuntos')->insert([
            ['asunto' => 'Administrativo'],
            ['asunto' => 'Academico'],
        ]);
    }
}
