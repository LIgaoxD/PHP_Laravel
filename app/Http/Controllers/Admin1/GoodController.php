<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use App\Repository\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopAdminUser;
use App\Models\ShopGood;
use App\Repository\GoodRepository;
use App\Repository\UserRepository;

class GoodController extends Controller
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

    /**
     * @var GoodRepository
     */
    private $goodRepository;

    public function __construct(
        Request $request,
        CommonRepository $commonRepository,
        UserRepository $userRepository,
        GoodRepository $goodRepository
    ) {
        $this->request = $request;
        $this->commonRepository = $commonRepository;
        $this->userRepository = $userRepository;
        $this->goodRepository = $goodRepository;
    }

    /**
     * 商品列表页
     */
    public function showGoodIndex()
    {
        $title = $this->request->input('title');
        $cate = $this->request->input('cate');
        $label = $this->request->input('label');
        $search_data = $this->request->input();

        $list = $this->goodRepository->listByAdmin($search_data);
        $data_rs = [
            'list' => $list,
            'cateRel' => ShopGood::cateRel(),
            'labelRel' => ShopGood::labelRel(),
            'title' => $title,
            'cate' => $cate,
            'label' => $label,
            'search_data' => $search_data,
        ];
        return view('admin1.good.index', $data_rs);
    }

    /**
     * 商品修改页
     */
    public function showGoodEdit()
    {
        $good_id = $this->request->input('good_id');
        $data_good = $good_id ? $this->goodRepository->getGood($good_id) : [];
        if ($good_id && !$data_good) {
            // TODO:404页
            return 404;
        }
        if ($data_good) {
            $data_good = $this->goodRepository->handleGood($data_good, 0);
        }

        $data_rs = [
            'cateRel' => ShopGood::cateRel(),
            'labelRel' => ShopGood::labelRel(),
            'h_title' => $good_id ? '编辑商品' : '新增商品',
            'data_good' => $data_good,
        ];
        return view('admin1.good.edit', $data_rs);
    }

    /**
     * 商品修改操作
     */
    public function goodEdit()
    {
        $good_id = $this->request->input('good_id');
        $title = $this->request->input('title');
        $title_sub = $this->request->input('title_sub', '');
        $cover = $this->request->input('cover', '');
        $amount = $this->request->input('amount', 0);
        $cate = $this->request->input('cate');
        $label = $this->request->input('label', []);

        $data_good = $good_id ? $this->goodRepository->getGood($good_id) : [];
        if ($good_id && !$data_good) {
            return response()->json([
                'code' => 1, 'msg' => '商品不存在',
            ]);
        }
//        $data_good = $this->goodRepository->handleGood($data_good);

        if (!$this->commonRepository->goodTitleValid($title)) {
            return response()->json([
                'code' => 1, 'msg' => '商品标题只能输入 50 个字符',
            ]);
        }
        if (!$this->commonRepository->goodTitleSubValid($title_sub)) {
            return response()->json([
                'code' => 1, 'msg' => '商品副标题只能输入100 个字符',
            ]);
        }
        if (!$this->commonRepository->goodCoverValid($cover)) {
            return response()->json([
                'code' => 1, 'msg' => '商品图片必须上传',
            ]);
        }
        if (!$this->commonRepository->goodAmountValid($amount)) {
            return response()->json([
                'code' => 1, 'msg' => '商品价格不能小于 0',
            ]);
        }
//        if (!$this->goodRepository->checkCate($cate)) {
//            return response()->json([
//                'code' => 1, 'msg' => '商品分类必选',
//            ]);
//        }
        if (!$this->goodRepository->checkLabelArr($label)) {
            return response()->json([
                'code' => 1, 'msg' => '商品标签有误',
            ]);
        }

        $input_data = $this->request->except('good_id');
        $this->goodRepository->editGood($data_good, $input_data);
        $msg = $good_id ? '编辑商品成功' : '新增商品成功';
        return response()->json([
            'code' => 0, 'msg' => $msg,
            'back' => true,
        ]);
    }

    /**
     * 商品图片上传操作
     */
    public function goodPic()
    {
        $file = $this->request->file('file');
        if (!$this->goodRepository->checkPicSize($file)) {
            return response()->json([
                'code' => 1, 'msg' => '图片大小不能超过 2MB',
            ]);
        }

        $res = $this->goodRepository->uploadPic($file);
        if ($res['code']) {
            return response()->json($res);
        }

        $data_re = [
            'pic' => $res['data']['url'],
        ];
        return response()->json([
            'code' => 0, 'msg' => '上传成功',
            'data' => $data_re,
        ]);
    }

    /**
     * 订单删除
     */
    public function goodDel()
    {
        $good_id = $this->request->input('order_no');

        $data_good = $good_id ? $this->goodRepository->getGood($good_id) : [];
        $this->goodRepository->goodDel($data_good);
        return response()->json([
            'code' => 0, 'msg' => '删除成功',
            'reload' => true,
        ]);
    }
}
