<?php

namespace App\Repository;

use App\Models\ShopGoodCollect;
use App\Models\ShopGoodLike;
use App\Models\ShopUser;

class UserRepository
{
    /**
     * 注册用户
     *
     * @param string $name
     * @param string $nickname
     * @param string $password
     * @param int $sex
     * @return ShopUser
     */
    public function register($name, $nickname, $password, $sex)
    {
        $model_user = new ShopUser();
        $model_user->name = $name;
        $model_user->nickname = $nickname;
        $model_user->password = $password;
        $model_user->sex = $sex;
        $model_user->intro = '';
        $model_user->save();
        return $model_user;
    }

    /**
     * 保存用户信息
     *
     * @param introValid $user
     * @param string $nickname
     * @param string $sex
     * @param string|null $intro
     * @return bool
     */
    public function saveUser($user, $nickname, $sex, $intro)
    {
        $user->nickname = $nickname;
        $user->sex = $sex;
        $user->intro = $intro ?? '';
        $rs = $user->save();
        return $rs;
    }

    /**
     * 个人首页的用户信息
     *
     * @param ShopUser $user
     * @return array
     */
    public function myInfo($user)
    {
        return [
            'name' => $user['name'],
            'nickname' => $user['nickname'],
            'intro' => $user['intro'],
            'sex_str' => $this->returnSexStr($user['sex']),
        ];
    }

    /**
     * 根据表存储的性别返回性别文字
     *
     * @param int $sex
     * @return string
     */
    public function returnSexStr($sex)
    {
        return ShopUser::sexRel()[$sex];
    }

    /**
     * 根据表存储的状态返回状态文字
     *
     * @param int $status
     * @return string
     */
    public function returnStatusStr($status)
    {
        return ShopUser::statusRel()[$status];
    }

    /**
     * 根据表存储的状态返回状态 class
     *
     * @param int $status
     * @return string
     */
    public function returnStatusClass($status)
    {
        return ShopUser::statusClass()[$status];
    }

    /**
     * 根据用户名查找用户
     *
     * @param string $name
     * @return ShopUser
     */
    public function getByName($name)
    {
        $rs = ShopUser::where('name', $name)->first();
        return $rs;
    }

    /**
     * 根据用户ID获取用户
     *
     * @param int $id
     * @return ShopUser
     */
    public function getUser($id)
    {
        $rs = ShopUser::find($id);
        return $rs;
    }

    /**
     * 保存密码
     *
     * @param ShopUser $user
     * @param string $pwd
     * @return bool
     */
    public function savePwd($user, $pwd)
    {
        $user->password = $pwd;
        $rs = $user->save();
        return $rs;
    }

    /**
     * 保存状态
     *
     * @param ShopUser $user
     * @param int $status
     * @return bool
     */
    public function saveStatus($user, $status)
    {
        $user->status = $status;
        $rs = $user->save();
        return $rs;
    }

    /**
     * 用户喜欢的商品
     *
     * @param int $user_id
     * @return array
     */
    public function listLikeGood($user_id)
    {
        $list = ShopGoodLike::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(6);

        $good_id_arr = $list->pluck('good_id');
        $goodRepo = new GoodRepository();
        $list_good = $goodRepo->findManyGood($good_id_arr)->keyBy('id');
        $list->map(function ($item) use ($list_good) {
            $curr_good = $list_good[$item['good_id']] ?? null;
            $item->good_title = $curr_good['title'] ?? '[未知商品]';
            $item->good_title_sub = $curr_good['title_sub'] ?? '';
            $item->good_cover = $curr_good['cover'] ?? '';
            $item->good_amount = $curr_good['amount'] ?? '';
            return $item;
        });
        return $list;
    }

    /**
     * 用户收藏的商品
     *
     * @param int $user_id
     * @return array
     */
    public function listCollectGood($user_id)
    {
        $list = ShopGoodCollect::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(6);

        $good_id_arr = $list->pluck('good_id');
        $goodRepo = new GoodRepository();
        $list_good = $goodRepo->findManyGood($good_id_arr)->keyBy('id');
        $list->map(function ($item) use ($list_good) {
            $curr_good = $list_good[$item['good_id']] ?? null;
            $item->good_title = $curr_good['title'] ?? '[未知商品]';
            $item->good_title_sub = $curr_good['title_sub'] ?? '';
            $item->good_cover = $curr_good['cover'] ?? '';
            $item->good_amount = $curr_good['amount'] ?? '';
            return $item;
        });
        return $list;
    }

    /**
     * 后台展示的用户列表
     *
     * @param array $search_data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listByAdmin($search_data)
    {
        $list = ShopUser::where(function ($query) use ($search_data) {
            $name = $search_data['name'] ?? '';
            $nickname = $search_data['nickname'] ?? '';
            $sex = $search_data['sex'] ?? '';
            $status = $search_data['status'] ?? '';
            if ($name) {
                $query->where('name', 'like', "%{$name}%");
            }
            if ($nickname) {
                $query->where('nickname', 'like', "%{$nickname}%");
            }
            if (is_numeric($sex)) {
                $query->where('sex', $sex);
            }
            if (is_numeric($status)) {
                $query->where('status', $status);
            }
        })
            ->orderBy('id', 'desc')
            ->paginate(10);
        $list->map(function ($item) {
            $item->status_str = $this->returnStatusStr($item->status);
            $item->status_class = $this->returnStatusClass($item->status);
            $item->sex_str = $this->returnSexStr($item->sex);
            return $item;
        });
        return $list;
    }

    /**
     * 检查支持的用户状态值
     *
     * @param int $val
     * @return bool
     */
    public function checkStatus($val)
    {
        $status_in = array_keys(ShopUser::statusRel());
        return in_array($val, $status_in);
    }

    /**
     * 检查是否禁用状态
     *
     * @param int $val
     * @return boolean
     */
    public function isStatusNo($val)
    {
        return $val === ShopUser::STATUS_NO;
    }

    /**
     * 根据用户ID数组查询所有用户
     *
     * @param array $user_id_arr
     * @return Collection
     */
    public function findManyUser($user_id_arr)
    {
        $rs = ShopUser::whereIn('id', $user_id_arr)->get();
        return $rs;
    }
}
