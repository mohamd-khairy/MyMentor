<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        
        factory('App\Models\User')->create([
            'name' => "mohamed",
            'email' => "m.khairy@evntoo.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'verified' => 1,
            'user_type_id' => 1,
            'role_id' => 1
        ])->each(function($u){
            $u->profile()->save(factory('App\Models\Profile')->create());
            $u->topicss()->save(factory('App\Models\Topics')->create());
        });
        
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
