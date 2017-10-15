<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\News\EloquentNews::class, function (Faker\Generator $faker) {
    return [
        'title' => __('seeding.news.title', ['number' => mt_rand(1, 1000)]),
        'content' => $faker->text(1024),
        'user_id' => 1
    ];
});
