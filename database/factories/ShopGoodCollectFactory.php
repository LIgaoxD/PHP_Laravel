<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShopGoodCollect;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ShopGoodCollect::class, function (Faker $faker) {
    $good_id_arr = [
        '1031',
        '1032',
        '1033',
        '1034',
        '1035',
        '1036',
        '1037',
        '1038',
        '1039',
        '1040',
        '1041',
        '1042',
        '1043',
        '1044',
        '1045',
        '1046',
        '1047',
        '1048',
    ];
    $good_id = $faker->randomElement($good_id_arr);
    $user_id = '1102';
    return [
        'good_id' => $good_id,
        'user_id' => $user_id,
    ];
});
