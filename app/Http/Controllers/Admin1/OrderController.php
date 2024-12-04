<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use App\Repository\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopAdminUser;
use App\Models\ShopOrder;
use App\Repository\OrderRepository;

class OrderController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ShopAdminUser
     */
    private $admin_user;

    /**
     * @var int
     */
    private $admin_user_id;

    /**
     * @var CommonRepository
     */
    private $commonRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(
        Request $request,
        CommonRepository $commonRepository,
        OrderRepository $orderRepository
    ) {
        $this->request = $request;
        $this->commonRepository = $commonRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * 订单列表页
     */
    public function showIndex()
    {
        $order_no = $this->request->input('order_no');
        $pay_status = $this->request->input('pay_status');
        $name = $this->request->input('name');
        $nickname = $this->request->input('nickname');
        $search_data = $this->request->input();

        $list = $this->orderRepository->listByAdmin($search_data);
        $data_rs = [
            'payRel' => ShopOrder::payRel(),
            'payClassRel' => ShopOrder::payClassRel(),
            'order_no' => $order_no,
            'pay_status' => $pay_status,
            'name' => $name,
            'nickname' => $nickname,
            'list' => $list,
            'search_data' => $search_data,
        ];
        return view('admin1.order.index', $data_rs);
    }

    /**
     * 订单删除
     */
    public function orderDel()
    {
        $order_no = $this->request->input('order_no');

        $data_order = $this->orderRepository->getOrder($order_no);
        if (!$data_order) {
            return response()->json([
                'code' => 1, 'msg' => '订单不存在',
            ]);
        }

        $this->orderRepository->orderDel($data_order);
        return response()->json([
            'code' => 0, 'msg' => '删除成功',
            'reload' => true,
        ]);
    }
}
