<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopConfig extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_config';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    const THEME_GAME = 'game';
    const THEME_COURSE = 'course';

    public static function themeRel()
    {
        return [
            self::THEME_COURSE => '关闭网站',
            self::THEME_GAME => '在线商城',
        ];
    }
}
