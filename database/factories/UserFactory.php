<?php declare(strict_types=1);

use App\Models\Auth\User\User;

$factory->define(
    User::class,
    function (Faker\Generator $faker) {
        return [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->email,
            'password' => app('hash')->make($faker->password),
        ];
    }
);
