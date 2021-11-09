<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert([
            'name' => 'admin',
            'email' =>'admin@siregar.com',
            'role' => 1,
            'password' => Hash::make('12345678'),
        ]);

        \DB::table('infra_types')->delete();

        \DB::table('infra_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type_code' => 'SVR',
                'type_name' => 'Server',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type_code' => 'STR',
                'type_name' => 'Storage',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
