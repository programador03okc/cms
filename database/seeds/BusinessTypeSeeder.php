<?php

use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.business_types')->insert([
            'name'          => 'VENTA WEB',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.business_types')->insert([
            'name'          => 'AFINIDAD',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.business_types')->insert([
            'name'          => 'AFINIDAD INTERNA',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
