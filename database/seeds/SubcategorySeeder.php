<?php

use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.subcategories')->insert([
            'name'          => 'DESKTOP',
            'slug'          => 'DES',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.subcategories')->insert([
            'name'          => 'NOTEBOOK',
            'slug'          => 'NBR',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.subcategories')->insert([
            'name'          => 'NOTEBOOK GAMING',
            'slug'          => 'NBG',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.subcategories')->insert([
            'name'          => 'NOTEBOOK TOUCH',
            'slug'          => 'NBT',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('admin.subcategories')->insert([
            'name'          => 'ALL IN ONE',
            'slug'          => 'AIO',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
        

        DB::table('admin.subcategories')->insert([
            'name'          => 'TABLET',
            'slug'          => 'TAB',
            'category_id'   => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
