<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('categories')->truncate();
        $data = [
            [
                'id' => 1,
                'name' => 'Programming'
            ],
            [
                'id' => 2,
                'name' => 'Languages'
            ]
        ];
        DB::table('categories')->insert($data);
    }
}
