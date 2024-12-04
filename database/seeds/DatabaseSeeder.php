<?php

use App\Models\ShopGood;
use App\Models\ShopGoodCollect;
use App\Models\ShopGoodLike;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\ShopUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(ShopUser::class, 100)->create();
        factory(ShopGood::class, 15)->create();
        // factory(ShopOrder::class, 15)->create();
        // factory(ShopOrderItem::class, 50)->create();
        // factory(ShopGoodCollect::class, 13)->create();
        // factory(ShopGoodLike::class, 13)->create();
    }
}
