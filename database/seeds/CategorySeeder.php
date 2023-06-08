<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.categories')->insert([
            'name'          => 'COMPUTO',
            'image'         => NULL,
            'path'          => NULL,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.categories')->insert([
            'name'          => 'IMPRESORAS',
            'image'         => NULL,
            'path'          => NULL,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.categories')->insert([
            'name'          => 'ACCESORIOS',
            'image'         => NULL,
            'path'          => NULL,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
