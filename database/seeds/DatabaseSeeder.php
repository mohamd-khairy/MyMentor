<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(WeekDays::class);
    }
}
