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

        $this->call(UserTypeSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(WeekDays::class);
        $this->call(LanguagesSeeder::class);
        $this->call(CategoriesSeeder::class);
        
        //users
        factory('App\Models\User', 10)->create([
            'user_type_id' => 2,
        ])
        ->each(function($u){
            $u->profile()->save(factory('App\Models\Profile')->create());
        });

        //mentors
        factory('App\Models\User', 10)->create([
            'user_type_id' => 1,
        ])
        ->each(function($u){
            $u->profile()->save(factory('App\Models\Profile')->create());
            $u->topicss()->save(factory('App\Models\Topics')->create());
        });

        
    }
}
