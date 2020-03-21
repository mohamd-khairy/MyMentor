<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'middle_name' => $faker->name,
        'last_name' => $faker->name,
        'address' => $faker->address,
        'city' => $faker->city,
        'country' => $faker->country,
        'phone_number' => $faker->unique()->phoneNumber,
        'mobile' => $faker->unique()->phoneNumber,
        'postal_code' => $faker->postcode,
        'date_of_birth' => $faker->date,
        'marital_status' => 1,
        'gender' => 'male',
        'photo' => $faker->image('public')
    ];
});
