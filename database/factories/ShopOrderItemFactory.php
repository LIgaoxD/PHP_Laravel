<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Controllers\Admin1\GoodController;
use App\Models\ShopOrderItem;
use App\Repository\GoodRepository;
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
$goodRepo = new GoodRepository();
$factory->define(ShopOrderItem::class, function (Faker $faker) use ($orderRepo, $goodRepo) {
    $order_no_arr = [
        'W220617712278',
        'W220617184384',
        'W220617423937',
        'W220617892889',
        'W220617405506',
        'W220617979914',
        'W220617185671',
        'W220617578590',
        'W220617311223',
        'W220617109171',
        'W220617126424',
        'W220617184611',
        'W220617454100',
        'W220617670365',
        'W220617787214',
    ];
    $order_no = $faker->randomElement($order_no_arr);
    $data_order = $orderRepo->getOrder($order_no);
    $num = $faker->numberBetween(1, 4);
    $amount_unit = $faker->randomFloat(2, 1, 7);

    $good_id_arr = [
        1031,
        1032,
        1033,
        1034,
        1035,
        1036,
        1037,
        1038,
        1039,
        1040,
    ];
    $good_id = $faker->randomElement($good_id_arr);
    $data_good = $goodRepo->getGood($good_id);
    return [
        'order_no' => $order_no,
        'user_id' => $data_order['user_id'],
        'good_id' => $good_id,
        'good_title' => $data_good['title'],
        'good_cover' => $data_good['cover'],
        'num' => $num,
        'amount_unit' => $amount_unit,
        'amount_sum' => $num * $amount_unit,
    ];
});
