<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use App\Repository\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopAdminUser;
use App\Models\ShopConfig;
use App\Repository\AdminRepository;
use App\Repository\AdminUserRepository;
use App\Repository\ConfigRepository;

class IndexController extends Controller
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
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var AdminRepository
     */
    private $adminRepository;

    public function __construct(
        Request $request,
        CommonRepository $commonRepository,
        AdminUserRepository $adminUserRepository,
        ConfigRepository $configRepository,
        AdminRepository $adminRepository
    ) {
        $this->request = $request;
        $this->commonRepository = $commonRepository;
        $this->adminUserRepository = $adminUserRepository;
        $this->configRepository = $configRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * 后台首页
     */
    public function showIndex()
    {
        $info = $this->adminRepository->indexInfo();
        $data_rs = [
            'info' => $info,
        ];
        return view('admin1.index.index', $data_rs);
    }

    /**
     * 后台登录页
     */
    public function showLogin()
    {
        return view('admin1.index.login');
    }

    /**
     * 后台登录操作
     */
    public function login()
    {
        $name = $this->request->input('name');
        $password = $this->request->input('password');
        if (empty($name)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名必填',
            ]);
        }
        if (empty($password)) {
            return response()->json([
                'code' => 1, 'msg' => '密码必填',
            ]);
        }

        $model_admin_user = $this->adminUserRepository->getByName($name);
        if (!$model_admin_user) {
            return response()->json([
                'code' => 1, 'msg' => '用户名或密码错误',
            ]);
        }
        if (strcmp($model_admin_user['password'], $password)) {
            return response()->json([
                'code' => 1, 'msg' => '用户名或密码错误',

            ]);
        }

        Auth::guard('admin')->login($model_admin_user);
        return response()->json([
            'code' => 0, 'msg' => '登录成功',
            'redirect' => '/admin/index',
        ]);
    }

    /**
     * 注销操作
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login')->with('toastr_info', '退出后台成功');
    }

    /**
     * 后台修改密码页
     */
    public function showPwd()
    {
        return view('admin1.index.pwd');
    }

    /**
     * 后台修改密码操作
     */
    public function pwd()
    {
        $pwd = $this->request->input('pwd');
        $pwd_re = $this->request->input('pwd_re');

        if (!$this->commonRepository->passwordValid($pwd)) {
            return response()->json([
                'code' => 1, 'msg' => '密码只能输入 4-20 个字符',
            ]);
        }
        if (strcmp($pwd, $pwd_re)) {
            return response()->json([
                'code' => 1, 'msg' => '重复密码不一致，请检查',
            ]);
        }

        $this->admin_user = $this->commonRepository->initAdminUser();
        $this->adminUserRepository->savePwd($this->admin_user, $pwd);
        return response()->json([
            'code' => 0, 'msg' => '修改密码成功',
            'reload' => true,
        ]);
    }

    /**
     * 站点配置页
     */
    public function showTheme()
    {
        $all_config = $this->configRepository->getAllConfig();
        $data_rs = [
            'all_config' => $all_config,
            'themeRel' => ShopConfig::themeRel(),
        ];
        return view('admin1.index.theme', $data_rs);
    }

    /**
     * 站点配置操作
     */
    public function theme()
    {
        $site_name = $this->request->input('site_name', '');
        $theme = $this->request->input('theme', '');

        if (!$site_name) {
            return response()->json([
                'code' => 1, 'msg' => '请填写站点名称',
            ]);
        }
        if (!$theme) {
            return response()->json([
                'code' => 1, 'msg' => '请选择主题',
            ]);
        }
        if (!$this->adminRepository->checkTheme($theme)) {
            return response()->json([
                'code' => 1, 'msg' => '主题错误',
            ]);
        }

        $this->configRepository->saveConfig('site_name', $site_name);
        $this->configRepository->saveConfig('theme', $theme);
        return response()->json([
            'code' => 0, 'msg' => '保存成功',
            'reload' => true,
        ]);
    }
}
