<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicios')->insert([
           'descripcion'=>'Corte Caballero',
           'precio'=>10
        ]);
        DB::table('servicios')->insert([
            'descripcion'=>'Corte Barba',
            'precio'=>10
         ]);
         DB::table('servicios')->insert([
            'descripcion'=>'teñido',
            'precio'=>7.20
         ]);
         DB::table('servicios')->insert([
            'descripcion'=>'Corte Señora',
            'precio'=>5
         ]);
         DB::table('servicios')->insert([
            'descripcion'=>'teñido',
            'precio'=>5
         ]);
    }
}
