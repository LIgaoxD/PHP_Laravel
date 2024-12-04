<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopUser extends Authenticatable
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_user';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    const SEX_MAN = 1;
    const SEX_WOMAN = 2;

    const STATUS_NO = 0;
    const STATUS_YES = 1;

    public static function sexRel()
    {
        return [
            self::SEX_MAN => '男',
            self::SEX_WOMAN => '女',
        ];
    }

    public static function statusRel()
    {
        return [
            self::STATUS_NO => '禁用',
            self::STATUS_YES => '启用',
        ];
    }

    public static function statusClass()
    {
        return [
            self::STATUS_NO => 'p-1 bg-dark text-white',
            self::STATUS_YES => 'p-1 text-success',
        ];
    }
}
