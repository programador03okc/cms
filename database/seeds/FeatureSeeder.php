<?php

use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'SISTEMA OPERATIVO',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'TAMAÑO',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'RESOLUCION',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'PROCESADOR',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'ALMACENAMIENTO',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'MEMORIA RAM',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'TARJETA DE VIDEO',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.features')->insert([
            'category_id'   => 1,
            'name'          => 'GARANTIA',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
