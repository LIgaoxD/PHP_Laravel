<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderItem extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_order_item';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public function goodData()
    {
        return $this->belongsTo(ShopGood::class, 'good_id', 'id');
    }
}
