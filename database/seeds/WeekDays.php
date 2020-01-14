<?php

use Illuminate\Database\Seeder;

class WeekDays extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('week_days')->truncate();
        $data = [
            [
                'id' => 1,
                'day' => 'saturday'
            ],
            [
                'id' => 2,
                'day' => 'sunday'
            ],
            [
                'id' => 3,
                'day' => 'monday'
            ],
            [
                'id' => 4,
                'day' => 'tuesday'
            ],
            [
                'id' => 5,
                'day' => 'wednesday'
            ],
            [
                'id' => 6,
                'day' => 'thursday'
            ],
            [
                'id' => 7,
                'day' => 'friday'
            ]
        ];
        DB::table('week_days')->insert($data);
    }
}
