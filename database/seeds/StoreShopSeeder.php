<?php

use Illuminate\Database\Seeder;

class StoreShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.store_shops')->insert([
            'name'          => 'OK COMPUTER WEB',
            'website'       => 'www.okcomputer.com',
            'created_at'    => date('Y-m-d H:i:s'),
        	'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
