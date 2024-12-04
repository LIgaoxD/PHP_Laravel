<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShopOrder;
use App\Repository\OrderRepository;
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

$orderRepo = new OrderRepository();
$factory->define(ShopOrder::class, function (Faker $faker) use ($orderRepo) {
    $pay_in = array_keys(ShopOrder::payRel());
    $pay_status = $faker->randomElement($pay_in);
    $pay_time = $orderRepo->isPayYes($pay_status)
        ? $faker->dateTimeThisMonth()
        : null;
    return [
        'order_no' => $orderRepo->createOrderNo(),
        'user_id' => $faker->numberBetween(1020, 1040),
        'amount_total' => $faker->randomFloat(2, 5, 100),
        'num' => $faker->numberBetween(1, 8),
        'pay_status' => $pay_status,
        'pay_time' => $pay_time,
    ];
});
