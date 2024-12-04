<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShopGood;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

$storage = Storage::disk('img');
$factory->define(ShopGood::class, function (Faker $faker) use ($storage) {
    $imageUrl = 'https://picsum.photos/400/600';
    $put_path = 'cover/' . $faker->md5 . '.jpg';
    $storage->put($put_path, file_get_contents($imageUrl));
    $url = $storage->url($put_path);
    return [
        'title' => $faker->text(80),
        'title_sub' => $faker->sentence($faker->numberBetween(5, 7)),
        'cover' => $url,
        'amount' => $faker->randomFloat(2, 0.1, 100),
        'cate' => $faker->numberBetween(1, 10) > 6 ? ShopGood::CATE_COURSE : ShopGood::CATE_GAME,
        'label' => $faker->numberBetween(1, 10) > 6 ? ShopGood::LABEL_TEJIAO : ShopGood::LABEL_REXIAO,
    ];
});
