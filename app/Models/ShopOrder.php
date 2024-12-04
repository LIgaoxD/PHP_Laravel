<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'shop_order';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    const PAY_WAIT = 0;
    const PAY_YES = 1;
    const PAY_NO = 2;

    public function orderItem()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_no', 'order_no');
    }

    public static function payRel()
    {
        return [
            self::PAY_WAIT => '待支付',
            self::PAY_YES => '支付成功',
            self::PAY_NO => '支付失败',
        ];
    }

    public static function payClassRel()
    {
        return [
            self::PAY_WAIT => 'badge badge-secondary badge-font',
            self::PAY_YES => 'badge badge-success badge-font',
            self::PAY_NO => 'badge badge-danger badge-font',
        ];
    }
}
