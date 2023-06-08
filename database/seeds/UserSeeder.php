<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin.users')->insert([
			'name' 				=> 'Edgar Alvarez',
			'email' 			=> 'programador2@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Erick Encinas',
			'email' 			=> 'distribucion@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Katerine Pezo',
			'email' 			=> 'marketing1@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Ana Diaz',
			'email' 			=> 'cm1@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Giovanni Magnani',
			'email' 			=> 'consumo@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Gustavo Cespedes',
			'email' 			=> 'marketing@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
        ]);
        
        DB::table('admin.users')->insert([
			'name' 				=> 'Nicole Medina',
			'email' 			=> 'comunidad@okcomputer.com.pe',
			'email_verified_at' => null,
			'password' 			=> Hash::make('123456'),
			'remember_token' 	=> Str::random(10),
			'created_at'		=> date('Y-m-d H:i:s'),
        	'updated_at'		=> date('Y-m-d H:i:s')
		]);
    }
}