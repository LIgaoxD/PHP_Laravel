<?php

namespace App\Repository;

use App\Models\ShopConfig;
use App\Models\ShopGood;
use App\Models\ShopOrder;
use App\Models\ShopUser;

class AdminRepository
{
    /**
     * 后台首页统计数据
     *
     * @return void
     */
    public function indexInfo()
    {
        $count_user = ShopUser::count();
        $count_order = ShopOrder::count();
        $count_good = ShopGood::count();
        return [
            'count_user' => $count_user,
            'count_order' => $count_order,
            'count_good' => $count_good,
        ];
    }
    /**
     * 检查支持的主题
     *
     * @param string $str
     * @return bool
     */
    public function checkTheme($str)
    {
        $theme_in = array_keys(ShopConfig::themeRel());
        return in_array($str, $theme_in);
    }
}
