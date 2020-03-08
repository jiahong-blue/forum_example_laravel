<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topic;
use Faker\Generator as Faker;

use App\User;
use App\Board;

$factory->define(Topic::class, function (Faker $faker) {

    $user = User::all()->pluck('id')->toArray();
    $board = Board::all()->pluck('id')->toArray();

    return [
        //
        "title" => $faker->title(10),
        "user_id" => $faker->randomElement($user),
        "board_id" => $faker->randomElement($board),
    ];
});
