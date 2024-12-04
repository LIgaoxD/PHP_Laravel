<?php

use App\Models\ShopUser;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ShopUser::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'nickname' => $faker->firstName . ' ' . $faker->lastName,
        'password' => '123456',
        'intro' => $faker->numberBetween(1, 10) > 7 ? $faker->sentence() : '',
        'sex' => $faker->numberBetween(1, 10) > 6 ? ShopUser::SEX_MAN : ShopUser::SEX_WOMAN,
        'status' => $faker->numberBetween(1, 10) > 8 ? ShopUser::STATUS_NO : ShopUser::STATUS_YES,
    ];
});
