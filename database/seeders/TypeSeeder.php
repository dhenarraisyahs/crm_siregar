<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
