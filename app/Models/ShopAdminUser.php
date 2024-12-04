<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopAdminUser extends Authenticatable
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_admin_user';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
