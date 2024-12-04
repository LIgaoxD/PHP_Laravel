<?php

namespace App\Repository;

use App\Models\ShopAdminUser;

class AdminUserRepository
{
    /**
     * 根据用户名查找用户
     *
     * @param string $name
     * @return ShopAdminUser
     */
    public function getByName($name)
    {
        $rs = ShopAdminUser::where('name', $name)->first();
        return $rs;
    }

    /**
     * 保存密码
     *
     * @param ShopAdminUser $user
     * @param string $pwd
     * @return bool
     */
    public function savePwd($user, $pwd)
    {
        $user->password = $pwd;
        $rs = $user->save();
        return $rs;
    }
}
