<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

use App\User;
use App\Topic;

$factory->define(Post::class, function (Faker $faker) {

    $user_id = User::all()->pluck('id')->toArray();
    $topic_id = Topic::all()->pluck('id')->toArray();

    return [
        //
        "message" => $faker->realText(200),
        "user_id" => $faker->randomElement($user_id),
        "topic_id" => $faker->randomElement($topic_id),
    ];
});
