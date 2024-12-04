<?php

namespace App\Repository;

use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\ShopUser;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    /**
     * -------------------------------------------------订单列表
     *
     * @param int $user_id
     * @return Collection
     */
    public function listOrder($user_id)
    {
        $list = ShopOrder::where('user_id', $user_id)
            ->with('orderItem.goodData')
            ->orderBy('id', 'desc')
            ->paginate(6);

        $list->map(function ($item) {
            $the_pay_status = $item['pay_status'];
            $is_pay_yes = $this->isPayYes($the_pay_status);
            $is_pay_wait = $this->isPayWait($the_pay_status);

            $item->pay_txt = $this->returnPayTxt($the_pay_status);
            $item->pay_class = $this->returnPayClass($the_pay_status);
            $item->pay_time = $is_pay_yes ? $item['pay_time'] : '';
            $item->is_pay_yes = $is_pay_yes;
            $item->is_pay_wait = $is_pay_wait;
            return $item;
        });
        return $list;
    }

    /**
     * --------------------------------------------------------是否支付成功状态
     *
     * @param int $pay_status
     * @return bool
     */
    public function isPayYes($pay_status)
    {
        return $pay_status === ShopOrder::PAY_YES;
    }

    /**
     * -------------------------------------------------------------------是否等待支付状态
     *
     * @param int $pay_status
     * @return bool
     */
    public function isPayWait($pay_status)
    {
        return $pay_status === ShopOrder::PAY_WAIT;
    }

    /**
     * ------------------------------------------------------------------------------根据支付状态返回给页面显示的文字
     *
     * @param int $pay_status
     * @return string
     */
    public function returnPayTxt($pay_status)
    {
        return ShopOrder::payRel()[$pay_status];
    }

    /**
     * --------------------------------------------------------------根据支付状态返回给页面显示的 class
     *
     * @param int $pay_status
     * @return string
     */
    public function returnPayClass($pay_status)
    {
        return ShopOrder::payClassRel()[$pay_status];
    }

    public function findManyOrderItem($order_no_arr)
    {
        $list = ShopOrderItem::whereIn('order_no', $order_no_arr)
            ->orderBy('id')
            ->get();
        return $list;
    }

    /**
     * -----------------------------------------------------根据订单号查找订单信息
     *
     * @param string $order_no
     * @return ShopOrder
     */
    public function getOrder($order_no)
    {
        $rs = ShopOrder::where('order_no', $order_no)->first();
        return $rs;
    }

    /**
     * ------------------------------------------------------检查订单号所属用户
     *
     * @param array $data_order
     * @param int $user_id
     * @return bool
     */
    public function checkOrderSelf($data_order, $user_id)
    {
        return $data_order['user_id'] == $user_id;
    }

    /**
     * ----------------------------------------------------------------检查支持的模拟支付状态
     *
     * @param int $val
     * @return bool
     */
    public function chekcMockStatus($val)
    {
        return in_array($val, $this->mockStatusIn());
    }

    /**
     * ------------------------------------------------------------支持的模拟支付状态
     *
     * @return array
     */
    public function mockStatusIn()
    {
        return [
            ShopOrder::PAY_WAIT,
            ShopOrder::PAY_YES,
            ShopOrder::PAY_NO,
        ];
    }

    /**
     * -------------------------------------------------修改订单支付状态
     *
     * @param ShopOrder $data_order
     * @param int $pay_status
     * @return bool
     */
    public function changeOrderStatus($data_order, $pay_status)
    {
        $data_order->pay_status = $pay_status;
        $rs = $data_order->save();
        return $rs;
    }

    /**
     * -------------------------------------------------生成唯一订单号
     *
     * @return string
     */
    public function createOrderNo()
    {
        do {
            $order_no = 'W' . date('ymd') . mt_rand(100000, 999999);
        } while ($this->getOrder($order_no));
        return $order_no;
    }

    /**
     *------------------------------------------------- 后台展示的订单列表
     *
     * @param array $search_data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listByAdmin($search_data)
    {
        $list = ShopOrder::where(function ($query) use ($search_data) {
            $order_no = $search_data['order_no'] ?? '';
            $pay_status = $search_data['pay_status'] ?? '';
            $name = $search_data['name'] ?? '';
            $nickname = $search_data['nickname'] ?? '';

            if ($order_no) {
                $query->where('order_no', 'like', "%{$order_no}%");
            }
            if (is_numeric($pay_status)) {
                $query->where('pay_status', $pay_status);
            }
            if ($name || $nickname) {
                $query_sub = ShopUser::where(function ($queryUser) use ($name, $nickname) {
                    if ($name) {
                        $queryUser->where('name', 'like', "%{$name}%");
                    }
                    if ($nickname) {
                        $queryUser->where('nickname', 'like', "%{$nickname}%");
                    }
                })
                    ->select('id');
                $query->whereIn('user_id', $query_sub);
            }
        })
            ->with('orderItem.goodData')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $user_id_arr = $list->pluck('user_id');
        $userRepo = new UserRepository();
        $list_user = $userRepo->findManyUser($user_id_arr)->keyBy('id');
        $list->map(function ($item) use ($list_user) {
            $curr_user = $list_user[$item->user_id] ?? null;
            $item->user_name = $curr_user['name'] ?? '[未知用户]';
            $item->user_nickname = $curr_user['nickname'] ?? '';

            $item->pay_str = $this->returnPayTxt($item->pay_status);
            $item->pay_class = $this->returnPayClass($item->pay_status);
            $item->is_pay_yes = $this->isPayYes($item->pay_status);
            $item->is_pay_wait = $this->isPayWait($item->pay_status);
            return $item;
        });
        return $list;
    }

    /**
     * -------------------------------------------------订单删除
     *
     * @param ShopOrder $data_order
     * @return bool
     */
    public function orderDel($data_order)
    {
        $rs = $data_order->delete();
        return $rs;
    }
}
