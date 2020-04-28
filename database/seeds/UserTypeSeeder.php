<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('user_types')->truncate();
        $data = [
            [
                'id' => 1,
                'user_type_name' => 'admin'
            ],
            [
                'id' => 2,
                'user_type_name' => 'mentor'
            ],
            [
                'id' => 3,
                'user_type_name' => 'user'
            ]
        ];
        DB::table('user_types')->insert($data);

    }
}
