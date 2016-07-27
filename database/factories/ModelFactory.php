<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'json_data' => json_encode([$faker->word => $faker->word])
    ];
});

$factory->define(\App\Collection::class, function (\Faker\Generator $faker) {
    return [
        'label' => $faker->sentence,
        'description' => $faker->paragraph
    ];
});

$factory->define(\App\Miniature::class, function (\Faker\Generator $faker) {
    return [
        'label' => $faker->sentence,
        'progress' => $faker->numberBetween(0, 100)
    ];
});

$factory->define(\App\Photo::class, function (\Faker\Generator $faker) {
    return [
        'url' => $faker->imageUrl(),
        'caption' => $faker->sentence,
        'title' => $faker->sentence
    ];
});
