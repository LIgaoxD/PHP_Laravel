<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use App\Repository\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopAdminUser;
use App\Models\ShopUser;
use App\Repository\UserRepository;

class UserController extends Controller
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
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        Request $request,
        CommonRepository $commonRepository,
        UserRepository $userRepository
    ) {
        $this->request = $request;
        $this->commonRepository = $commonRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * 用户列表
     */
    public function showIndex()
    {
        $status = $this->request->input('status');
        $sex = $this->request->input('sex');
        $name = $this->request->input('name');
        $nickname = $this->request->input('nickname');
        $search_data = $this->request->input();

        $list = $this->userRepository->listByAdmin($search_data);
        $data_rs = [
            'list' => $list,
            'sexRel' => ShopUser::sexRel(),
            'statusRel' => ShopUser::statusRel(),
            'status' => $status,
            'sex' => $sex,
            'name' => $name,
            'nickname' => $nickname,
            'search_data' => $search_data,
        ];
        return view('admin1.user.index', $data_rs);
    }

    /**
     * 修改用户密码
     */
    public function userPwd()
    {
        $user_id = $this->request->input('user_id');
        $pwd = $this->request->input('pwd');
        $pwd_re = $this->request->input('pwd_re');

        $user = $this->userRepository->getUser($user_id);
        if (!$user) {
            return response()->json([
                'code' => 1, 'msg' => '用户不存在',
            ]);
        }
        if (!$this->commonRepository->passwordValid($pwd)) {
            return response()->json([
                'code' => 1, 'msg' => '密码只能输入 4-20 个字符',
            ]);
        }
        // if (strcmp($pwd, $pwd_re)) {
        //     return response()->json([
        //         'code' => 1, 'msg' => '重复密码不一致，请检查',
        //     ]);
        // }

        $this->userRepository->savePwd($user, $pwd);
        return response()->json([
            'code' => 0, 'msg' => '修改成功',
        ]);
    }

    /**
     * 修改用户状态
     */
    public function userDeny()
    {
        $user_id = $this->request->input('user_id');
        $status = $this->request->input('status');

        $user = $this->userRepository->getUser($user_id);
        if (!$user) {
            return response()->json([
                'code' => 1, 'msg' => '用户不存在',
            ]);
        }
        if (!$this->userRepository->checkStatus($status)) {
            return response()->json([
                'code' => 1, 'msg' => '用户状态错误',
            ]);
        }

        $this->userRepository->saveStatus($user, $status);
        return response()->json([
            'code' => 0, 'msg' => '修改成功',
            'reload' => true,
        ]);
    }
}
