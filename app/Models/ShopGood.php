<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopGood extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_good';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    const CATE_GAME = 1;
    const CATE_COURSE = 2;

    const LABEL_TEJIAO = 'tejiao';
    const LABEL_REXIAO = 'rexiao';

    public static function cateRel()
    {
        return [
            self::CATE_GAME => '游戏',
            self::CATE_COURSE => '课程',
        ];
    }

    public static function labelRel()
    {
        return [
            self::LABEL_TEJIAO => '特价',
            self::LABEL_REXIAO => '热销',
        ];
    }
}
