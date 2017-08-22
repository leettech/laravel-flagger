<?php

$factory->define(config('flagger.model'), function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Leet\Models\Feature::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->text,
    ];
});
