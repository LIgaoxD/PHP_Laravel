<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopGoodLike extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_good_like';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
