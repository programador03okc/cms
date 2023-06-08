<?php

use Illuminate\Database\Seeder;

class ArtTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.art_types')->insert([
            'name'          => 'PORTADA',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.art_types')->insert([
            'name'          => 'GALERIA',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.art_types')->insert([
            'name'          => 'BANNER',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
