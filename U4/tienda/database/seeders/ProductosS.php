<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            'nombre'=>'Ratón inalámbrico',
            'precio'=>'10.20',
            'stock'=>30,
            'imagen'=>'1.jpg'
        ]);
        DB::table('productos')->insert([
            'nombre'=>'Módulo RAM DDR4 KINGSTON 32GB',
            'precio'=>'40.00',
            'stock'=>3,
            'imagen'=>'2.jpg'
        ]);
        DB::table('productos')->insert([
            'nombre'=>'Disco duro NVME M.2 SATA 3TB WD GREEN',
            'precio'=>'100.00',
            'stock'=>10,
            'imagen'=>'3.jpg'
        ]);

    }
}
