<?php

namespace App\Http\Controllers\Shop1;

use App\Http\Controllers\Controller;
use App\Models\ShopGood;
use App\Repository\CommonRepository;
use App\Repository\ConfigRepository;
use App\Repository\GoodRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopUser;

class IndexController extends Controller
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
     * @var GoodRepository
     */
    private $goodRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CommonRepository
     */
    private $commonRepository;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        Request $request,
        GoodRepository $goodRepository,
        UserRepository $userRepository,
        CommonRepository $commonRepository,
        ConfigRepository $configRepository
    ) {
        $this->request = $request;
        $this->goodRepository = $goodRepository;
        $this->userRepository = $userRepository;
        $this->commonRepository = $commonRepository;
        $this->configRepository = $configRepository;
    }

    /**
     * ----------------------------------------------------------------首页
     */
    public function showIndex()
    {
        // 从请求中获取标签和当前主题配置
        $label = $this->request->input('label', '');
        $theme = $this->configRepository->getConfig('theme');

        // 获取首页商品列表
        $list = $this->goodRepository->listGoodByIndex($theme, $label);

        // 封装数据
        $data_rs = [
            'labelRel' => ShopGood::labelRel(),
            'label' => $label,
            'theme_txt' => $this->configRepository->returnThemeTxt($theme),
            'list' => $list,
        ];

        // 返回首页视图
        return view('shop1.index.index', $data_rs);
    }

    /**
     * 登录页
     */
    public function showLogin()
    {
        // 返回登录页视图
        return view('shop1.index.login');
    }

    /**
     * ----------------------------------------------------------注册页
     */
    public function showRegister()
    {
        // 返回注册页视图
        return view('shop1.index.register');
    }


    /**
     * ----------------------------------------------------------------------登录操作
     */
    public function login()
    {
        // 从请求中获取用户名和密码
        $name = $this->request->input('name');
        $password = $this->request->input('password');

        // 验证用户名是否为空
        if (empty($name)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名必填',
            ]);
        }

        // 验证密码是否为空
        if (empty($password)) {
            return response()->json([
                'code' => 1, 'msg' => '密码必填',
            ]);
        }

        // 通过用户名获取用户模型
        $model_user = $this->userRepository->getByName($name);

        // 验证用户是否存在
        if (!$model_user) {
            return response()->json([
                'code' => 1, 'msg' => '用户名或密码错误',
            ]);
        }

        // 验证密码是否正确
        if (strcmp($model_user['password'], $password)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名或密码错误',
            ]);
        }

        // 检查用户状态是否正常
        if ($this->userRepository->isStatusNo($model_user->status)) {
            return response()->json([
                'code' => 10, 'msg' => '用户已被禁用，无法操作！',
            ]);
        }

        // 使用web guard进行登录
        Auth::guard('web')->login($model_user);

        // 返回登录成功的 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '登录成功',
            'redirect' => '/my/index',
        ]);
    }

    /**
     * -----------------------------------------------------------------------注册操作
     */
    public function register()
    {
        // 从请求中获取注册信息
        $name = $this->request->input('name');
        $nickname = $this->request->input('nickname', '');
        $password = $this->request->input('password');
        $sex = $this->request->input('sex');

        // 验证用户名是否合法
        if (!$this->commonRepository->nameValid($name)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名只能输入 4-20 个字符',
            ]);
        }

        // 检查用户名是否已存在
        if ($this->userRepository->getByName($name)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名已存在，请更换其它的',
            ]);
        }

        // 验证昵称是否合法
        if (!$this->commonRepository->nicknameValid($nickname)) {
            return response()->json([
                'code' => 1, 'msg' => '昵称只能输入 4-20 个字符',
            ]);
        }

        // 验证密码是否合法
        if (!$this->commonRepository->passwordValid($password)) {
            return response()->json([
                'code' => 1, 'msg' => '密码只能输入 4-20 个字符',
            ]);
        }

        // 验证性别是否合法
        if (!$this->commonRepository->sexValid($sex)) {
            return response()->json([
                'code' => 1, 'msg' => '性别必须选择',
            ]);
        }

        // 注册用户并获取用户模型
        $model_user = $this->userRepository->register($name, $nickname, $password, $sex);

        // 使用web guard进行登录
        Auth::guard('web')->login($model_user);

        // 返回注册成功的 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '注册成功',
            'redirect' => '/my/index',
        ]);
    }


    /**
     * -----------------------------------------------------------------------注销操作
     */
    public function logout()
    {
        // 使用web guard进行用户注销
        Auth::guard('web')->logout();

        // 重定向到首页并携带成功消息
        return redirect('/')->with('toastr_info', '注销成功');
    }

    /**
     * --------------------------------------------------------------商品详情页
     */
    public function showGoodDetail()
    {
        // 从请求中获取商品ID
        $good_id = $this->request->input('good_id');

        // 获取商品信息
        $data = $this->goodRepository->getGood($good_id);

        // 如果商品不存在，返回404页面
        if (!$data) {
            // TODO:404页面
            return 404;
        }

        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 处理商品信息
        $rs = $this->goodRepository->handleGood($data, $this->user_id);

        // 封装数据
        $data_rs = [
            'rs' => $rs,
        ];

        // 返回商品详情页视图
        return view('shop1.index.good_detail', $data_rs);
    }

    /**
     * ----------------------------------------------------------------购物车页
     */
    public function showGoodCart()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取用户购物车信息
        $data_cart = $this->goodRepository->getCart($this->user_id);

        // 处理购物车商品信息
        $rs = $this->goodRepository->handleGoodForCart($data_cart);

        // 封装数据
        $data_rs = [
            'rs' => $rs,
        ];

        // 返回购物车页面视图
        return view('shop1.index.good_cart', $data_rs);
    }

    /**
     * -----------------------------------------------------------------------------------加入购物车操作
     */
    public function goodAddCart()
    {
        // 从请求中获取商品ID和数量
        $good_id = $this->request->input('good_id');
        $good_num = $this->request->input('good_num', 1);

        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取购物车信息
        $data_cart = $this->goodRepository->addCart($good_id, $good_num, $this->user_id);

        // 保存购物车信息
        $this->goodRepository->saveCart($data_cart, $this->user_id);

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '加入购物车成功',
            'reload' => 1,
        ]);
    }


    /**
     * ------------------------------------------------------------------------购物车结算
     */
    public function goodSubmit()
    {
        // 获取支付状态和总金额
        $pay_status = $this->request->input('pay_status', 1); // 支付状态
        $amount_sum = $this->request->input('amount_sum'); // 传入总金额，用来判断是否一致，不一致时进行提示
        $pay_status = intval($pay_status);

        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取用户购物车信息
        $good_cart = $this->goodRepository->getCart($this->user_id);

        // 如果购物车为空，返回相应的错误响应
        if (!$good_cart) {
            return response()->json([
                'code' => 1, 'msg' => '购物车空空如也',
            ]);
        }

        // 检查购物车金额是否一致，若不一致则返回相应的错误响应
        if (!$this->goodRepository->checkCartAmountSame($good_cart, $amount_sum)) {
            return response()->json([
                'code' => 1, 'msg' => '结算金额有变化，请刷新页面',
            ]);
        }

        // 提交购物车，更新支付状态
        $this->goodRepository->submitCart($good_cart, $this->user_id, $pay_status);

        // 清空用户购物车
        $this->goodRepository->delCart($this->user_id);

        // 返回购物成功的 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => '提交成功',
            'redirect' => '/my/order',
        ]);
    }

    /**
     * ----------------------------------------------------------------------商品收藏操作
     */
    public function goodCollect()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取商品ID和收藏状态
        $good_id = $this->request->input('good_id');
        $is_yes = $this->request->input('is_yes', 1);

        // 执行商品收藏操作
        $this->goodRepository->goodCollect($this->user_id, $good_id, $is_yes);

        // 根据收藏状态返回相应的提示消息
        $msg = $is_yes ? '已收藏' : '取消收藏';

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => $msg,
            'reload' => true,
        ]);
    }

    /**
     * ---------------------------------------------------------------------------商品点赞操作
     */
    public function goodLike()
    {
        // 初始化用户ID
        $this->user_id = $this->commonRepository->initUserId();

        // 获取商品ID和点赞状态
        $good_id = $this->request->input('good_id');
        $is_yes = $this->request->input('is_yes', 1);

        // 执行商品点赞操作
        $this->goodRepository->goodLike($this->user_id, $good_id, $is_yes);

        // 根据点赞状态返回相应的提示消息
        $msg = $is_yes ? '已点赞' : '取消点赞';

        // 返回 JSON 响应
        return response()->json([
            'code' => 0, 'msg' => $msg,
            'reload' => true,
        ]);
    }
}

