<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topics;
use Faker\Generator as Faker;

$factory->define(Topics::class, function (Faker $faker) {
    return [
        'topic' => $faker->word,
        'subject' => $faker->paragraph,
        'details' => $faker->paragraph,
        'language_id' => 3,
        'category_id' => 1
    ];
});
