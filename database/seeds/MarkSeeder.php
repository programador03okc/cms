<?php

use Illuminate\Database\Seeder;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.marks')->insert([
            'name'          => 'ACER',
            'slug'          => 'ACE',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => 'ASUS',
            'slug'          => 'ASU',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => 'DELL',
            'slug'          => 'ACE',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => 'HP',
            'slug'          => 'HP',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => 'HUAWEI',
            'slug'          => 'HUA',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => 'LENOVO',
            'slug'          => 'LEN',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.marks')->insert([
            'name'          => utf8_encode('@NOTEPAD'),
            'slug'          => 'NOT',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
