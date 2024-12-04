<?php

namespace App\Http\Controllers\Shop1;

use App\Http\Controllers\Controller;
use App\Repository\CommonRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopUser;
use App\Repository\OrderRepository;
use PhpParser\ErrorHandler\Collecting;

class MyController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ShopUser
     */
    private $user;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var CommonRepository
     */
    private $commonRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        Request $request,
        OrderRepository $orderRepository,
        CommonRepository $commonRepository,
        UserRepository $userRepository
    ) {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->commonRepository = $commonRepository;
        $this->userRepository = $userRepository;
    }

    //我的主页
    public function showIndex()
    {
        // 初始化用户信息
        $this->user = $this->commonRepository->initUser();

        // 获取用户信息
        $info = $this->userRepository->myInfo($this->user);

        // 封装数据
        $data_rs = [
            'info' => $info,
        ];

        // 返回视图
        return view('shop1.my.index', $data_rs);
    }

    //修改个人信息页
    public function showEdit()
    {
        // 初始化用户信息
        $this->user = $this->commonRepository->initUser();

        // 封装数据
        $data_rs = [
            'user' => $this->user,
        ];

        // 返回视图
        return view('shop1.my.edit', $data_rs);
    }

    //修改个人信息
    public function edit()
    {
        // 从请求中获取用户提交的个人信息
        $nickname = $this->request->input('nickname', '');
        $sex = $this->request->input('sex', '');
        $intro = $this->request->input('intro', '');

        // 验证昵称长度是否合法
        if (!$this->commonRepository->nicknameValid($nickname)) {
            return response()->json([
                'code' => 1, 'msg' => '昵称只能输入 4-20 个字符',
            ]);
        }

        // 验证性别是否合法
        if (!$this->commonRepository->sexValid($sex)) {
            return response()->json([
                'code' => 1, 'msg' => '性别必须选择',
            ]);
        }

        // 验证个人介绍长度是否合法
        if (!$this->commonRepository->introValid($intro)) {
            return response()->json([
                'code' => 1, 'msg' => '个人介绍不能超过 200 个字符',
            ]);
        }

        // 初始化用户信息
        $this->user = $this->commonRepository->initUser();

        // 保存用户信息
        $this->userRepository->saveUser($this->user, $nickname, $sex, $intro);

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '保存成功',
            'redirect' => '/my/index',
        ]);
    }

    //修改密码页
    public function showPwd()
    {
        // 返回修改密码页面视图
        return view('shop1.my.pwd');
    }

    //修改密码
    public function pwd()
    {
        // 从请求中获取新密码和确认密码
        $pwd = $this->request->input('pwd');
        $pwd_re = $this->request->input('pwd_re');

        // 验证密码长度是否合法
        if (!$this->commonRepository->passwordValid($pwd)) {
            return response()->json([
                'code' => 1, 'msg' => '密码只能输入 4-20 个字符',
            ]);
        }

        // 检查两次输入的密码是否一致
        if (strcmp($pwd, $pwd_re)) {
            return response()->json([
                'code' => 1, 'msg' => '重复密码不一致，请检查',
            ]);
        }

        // 初始化用户信息
        $this->user = $this->commonRepository->initUser();

        // 保存新密码
        $this->userRepository->savePwd($this->user, $pwd);

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '修改成功',
            'redirect' => '/my/index',
        ]);
    }



    //收藏的商品列表
    public function showCollect()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取用户收藏的商品列表
        $list = $this->userRepository->listCollectGood($this->user_id);

        // 封装数据
        $data_rs = [
            'list' => $list,
        ];

        // 返回视图
        return view('shop1.my.collect', $data_rs);
    }


    //喜欢的商品列表
    public function showLike()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取用户喜欢的商品列表
        $list = $this->userRepository->listLikeGood($this->user_id);

        // 封装数据
        $data_rs = [
            'list' => $list,
        ];

        // 返回视图
        return view('shop1.my.like', $data_rs);
    }

    //订单列表页
    public function showOrder()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取用户的订单列表
        $list = $this->orderRepository->listOrder($this->user_id);

        // 封装数据
        $data_rs = [
            'list' => $list,
        ];

        // 返回视图
        return view('shop1.my.order', $data_rs);
    }

    //模拟订单支付
    public function orderPay()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 从请求中获取订单号和模拟支付状态
        $order_no = $this->request->input('order_no');
        $mock_status = $this->request->input('mock_status');

        // 获取订单信息
        $data_order = $this->orderRepository->getOrder($order_no);

        // 如果订单不存在，返回错误响应
        if (!$data_order) {
            return response()->json([
                'code' => 1, 'msg' => '订单不存在',
            ]);
        }

        // 检查订单是否属于当前用户
        if (!$this->orderRepository->checkOrderSelf($data_order, $this->user_id)) {
            return response()->json([
                'code' => 1, 'msg' => '订单不存在',
            ]);
        }

        // 检查模拟支付状态是否合法
        if (!$this->orderRepository->chekcMockStatus($mock_status)) {
            return response()->json([
                'code' => 1, 'msg' => '支付状态错误',
            ]);
        }

        // 更新订单状态
        $this->orderRepository->changeOrderStatus($data_order, $mock_status);

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '操作成功',
            'reload' => true,
        ]);
    }
}
