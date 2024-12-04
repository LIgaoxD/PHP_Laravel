<?php

namespace App\Repository;

use App\Models\ShopConfig;
use App\Models\ShopGood;
use App\Models\ShopGoodCollect;
use App\Models\ShopGoodLike;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class GoodRepository
{
    /**
     * 收藏商品
     *
     * @param int $user_id
     * @param int $good_id
     * @param int $is_yes
     * @return bool
     */
    public function goodCollect($user_id, $good_id, $is_yes)
    {
        if ($is_yes) {
            if (!$this->hasGoodCollect($user_id, $good_id)) {
                $rs = $this->addGoodCollect($user_id, $good_id);
                return $rs;
            }
        } else {
            if ($this->hasGoodCollect($user_id, $good_id)) {
                $rs = $this->delGoodCollect($user_id, $good_id);
                return $rs;
            }
        }
        return true;
    }

    public function addGoodCollect($user_id, $good_id)
    {
        $model_collect = new ShopGoodCollect();
        $model_collect->user_id = $user_id;
        $model_collect->good_id = $good_id;
        $rs = $model_collect->save();
        return $rs;
    }

    public function delGoodCollect($user_id, $good_id)
    {
        $rs = ShopGoodCollect::where('user_id', $user_id)
            ->where('good_id', $good_id)
            ->delete();
        return $rs;
    }

    /**
     * 用户是否已经收藏
     *
     * @param int $user_id
     * @param int $good_id
     * @return ShopGoodCollect
     */
    public function hasGoodCollect($user_id, $good_id)
    {
        $rs = ShopGoodCollect::where('user_id', $user_id)
            ->where('good_id', $good_id)
            ->first();
        return $rs;
    }


    /**
     * 喜欢商品
     *
     * @param int $user_id
     * @param int $good_id
     * @param int $is_yes
     * @return bool
     */
    public function goodLike($user_id, $good_id, $is_yes)
    {
        if ($is_yes) {
            if (!$this->hasGoodLike($user_id, $good_id)) {
                $rs = $this->addGoodLike($user_id, $good_id);
                return $rs;
            }
        } else {
            if ($this->hasGoodLike($user_id, $good_id)) {
                $rs = $this->delGoodLike($user_id, $good_id);
                return $rs;
            }
        }
        return true;
    }

    public function addGoodLike($user_id, $good_id)
    {
        $model_like = new ShopGoodLike();
        $model_like->user_id = $user_id;
        $model_like->good_id = $good_id;
        $rs = $model_like->save();
        return $rs;
    }

    public function delGoodLike($user_id, $good_id)
    {
        $rs = ShopGoodLike::where('user_id', $user_id)
            ->where('good_id', $good_id)
            ->delete();
        return $rs;
    }

    /**
     * 用户是否已经点赞
     *
     * @param int $user_id
     * @param int $good_id
     * @return ShopGoodLike
     */
    public function hasGoodLike($user_id, $good_id)
    {
        $rs = ShopGoodLike::where('user_id', $user_id)
            ->where('good_id', $good_id)
            ->first();
        return $rs;
    }


    /**
     * 查询指定ID的商品
     *
     * @param int $good_id
     * @return ShopGood
     */
    public function getGood($good_id)
    {
        $rs = ShopGood::find($good_id);
        return $rs;
    }

    /**
     * 处理商品数据，返回给页面显示
     *
     * @param ShopGood $data_good
     * @param int $user_id
     * @return ShopGood
     */
    public function handleGood($data_good, $user_id)
    {
        $data_good->label_data = $this->returnLabelMulti($data_good['label']);
        $data_good->label_arr = $this->returnLabelArr($data_good['label']);
        $data_good->cate_txt = $this->returnCateTxt($data_good['cate']);
        // 如果未登录，默认是没有点赞和收藏
        $data_good->is_like = false;
        $data_good->is_collect = false;
        if ($user_id) {
            $data_good->is_like = !!$this->hasGoodLike($user_id, $data_good['id']);
            $data_good->is_collect = !!$this->hasGoodCollect($user_id, $data_good['id']);
        }
        return $data_good;
    }

    /**
     * 根据数据表存储的分类ID，返回对应的中文分类名称
     *
     * @param string $cate
     * @return string
     */
    public function returnCateTxt($cate)
    {
        $cate_txt = ShopGood::cateRel()[$cate];
        return $cate_txt;
    }

    /**
     * 根据数据表存储的英文标签，返回对应的中文标签数组
     *
     * @param string $label
     * @return array
     */
    public function returnLabelArr($label)
    {
        $label_multi = $this->returnLabelMulti($label);
        $arr = [];
        foreach ($label_multi as $label_item) {
            $arr[] = ShopGood::labelRel()[$label_item];
        }
        return $arr;
    }

    /**
     * 返回标签英文数组
     *
     * @param string $label
     * @return array
     */
    public function returnLabelMulti($label)
    {
        $label_multi = explode(',', $label);
        $label_multi = array_values(array_filter($label_multi));
        return $label_multi;
    }

    /**
     * -------------------------------------------------商品及数量加入COOKIE存储的购物车
     *
     * @param int $good_id
     * @param int $good_num
     * @param int $user_id
     * @return array
     */
    public function addCart($good_id, $good_num, $user_id)
    {
        $cart = $this->getCart($user_id);
        $is_exist = false;
        foreach ($cart as &$cart_item) {
            if ($cart_item['id'] == $good_id) {
                $is_exist = true;
                $cart_item['num'] += $good_num;
                break;
            }
        }
        unset($cart_item);
        if (!$is_exist) {
            $cart[] = [
                'id' => $good_id,
                'num' => $good_num,
            ];
        }
        return $cart;
    }

    /**
     * -------------------------------------------------获取COOKIE存储的购物车信息
     *
     * @param int $user_id
     * @return array
     */
    public function getCart($user_id)
    {
        $cookie_key = 'good_cart_' . $user_id;
        $rs = Cookie::get($cookie_key, '[]');
        $rs = array_filter(json_decode($rs, true));
        return $rs;
    }

    /**
     * -------------------------------------------------保存购物车信息到COOKIE存储
     *
     * @param array $data_cart
     * @param int $user_id
     * @return void
     */
    public function saveCart($data_cart, $user_id)
    {
        $cookie_key = 'good_cart_' . $user_id;
        Cookie::queue($cookie_key, json_encode($data_cart), 60*24);
    }

    /**
     * -------------------------------------------------清空COOKIE存储的购物车信息
     *
     * @param int $user_id
     * @return void
     */
    public function delCart($user_id)
    {
        $cookie_key = 'good_cart_' . $user_id;
        Cookie::queue(Cookie::forget($cookie_key));
    }

    /**
     * -------------------------------------------------购物车里的商品数量
     *
     * @param int $user_id
     * @return int
     */
    public function cartNum($user_id)
    {
        $data_cart = $this->getCart($user_id);
        $data_num = array_column($data_cart, 'num');
        return array_sum($data_num);
    }

    /**
     * -------------------------------------------------检查购物车的商品总价格是否与传入的值一致
     *
     * @param array $good_cart
     * @param float $amount_sum
     * @return bool
     */
    public function checkCartAmountSame($good_cart, $amount_sum)
    {
        $list_good = $this->listGoodForCart($good_cart);
        $sum = 0;
        foreach ($good_cart as $item_cart) {
            $curr_good = $list_good[$item_cart['id']] ?? null;
            if (!$curr_good) {
                continue;
            }

            $price_sum = 100 * floatval($curr_good['amount']) * $item_cart['num'];
            $sum += $price_sum;
        }
        return floatval($sum) == floatval($amount_sum * 100);
    }

    /**
     * -------------------------------------------------购物国结算
     *
     * @param array $good_cart
     * @param int $user_id
     * @param int $pay_status
     * @return bool
     */
    public function submitCart($good_cart, $user_id, $pay_status)
    {
        $orderRepo = new OrderRepository();
        $commonRepo = new CommonRepository();
        $order_no = $orderRepo->createOrderNo();
        $list_good = $this->listGoodForCart($good_cart);
        $num = 0;
        $amount_total = 0;
        foreach ($good_cart as $item_cart) {
            $curr_good = $list_good[$item_cart['id']] ?? null;
            if (!$curr_good) {
                continue;
            }

            $good_num = $item_cart['num'];
            $good_amount = floatval($curr_good['amount']);
            $price_sum = 100 * $good_amount * $good_num;

            $num += $good_num;
            $amount_total += $price_sum;

            $model_order_item = new ShopOrderItem();
            $model_order_item->order_no = $order_no;
            $model_order_item->user_id = $user_id;
            $model_order_item->good_id = $curr_good['id'];
            $model_order_item->good_title = $curr_good['title'];
            $model_order_item->good_cover = $curr_good['cover'];
            $model_order_item->num = $good_num;
            $model_order_item->amount_unit = $good_amount;
            $model_order_item->amount_sum = $price_sum / 100;
            $model_order_item->save();
        }
        $model_order = new ShopOrder();
        $model_order->order_no = $order_no;
        $model_order->user_id = $user_id;
        $model_order->amount_total = $amount_total / 100;
        $model_order->num = $num;
        $model_order->pay_status = $pay_status;
        if ($orderRepo->isPayYes($pay_status)) {
            $model_order->pay_time = $commonRepo->dateTimeStr();
        }
        $model_order->save();
    }

    /**
     * -------------------------------------------------购物车里的商品信息
     *
     * @param array $list_cart
     * @return Collection
     */
    private function listGoodForCart($list_cart)
    {
        $good_id_arr = array_column($list_cart, 'id');
        $list_good = collect([]);
        if ($good_id_arr) {
            $list_good = $this->findManyGood($good_id_arr)->keyBy('id');
        }
        return $list_good;
    }

    /**
     * -------------------------------------------------购物车里的商品信息
     *
     * @param array $list_cart
     * @return array
     */
    public function handleGoodForCart($list_cart)
    {
        $common = new CommonRepository();
        $list_good = $this->listGoodForCart($list_cart);

        $sum = 0;
        $list = [];
        foreach ($list_cart as $item_cart) {
            $curr_good = $list_good[$item_cart['id']] ?? null;
            if (!$curr_good) {
                continue;
            }

            $price_sum = 100 * floatval($curr_good['amount']) * $item_cart['num'];
            $sum += $price_sum;

            $price_sum = $common->priceFormat($price_sum / 100);
            $price_unit = $common->priceFormat($curr_good['amount']);
            $list[] = [
                'id' => $item_cart['id'],
                'num' => $item_cart['num'],
                'title' => $curr_good['title'],
                'cover' => $curr_good['cover'],
                'price_unit' => $price_unit,
                'price_sum' => $price_sum,
            ];
        }

        $sum = $common->priceFormat($sum / 100);
        return [
            'list' => $list,
            'sum' => $sum,
        ];
    }

    /**
     * -------------------------------------------------根据商品ID数组查询所有商品
     *
     * @param array $good_id_arr
     * @return Collection
     */
    public function findManyGood($good_id_arr)
    {
        $rs = ShopGood::whereIn('id', $good_id_arr)->get();
        return $rs;
    }

    /**
     * -------------------------------------------------商品列表（首页使用）
     *
     * @param string $theme
     * @param string $label_str
     * @return Collection
     */
    public function listGoodByIndex($theme, $label_str)
    {
        $cate = strtolower($theme) === ShopConfig::THEME_GAME
            ? ShopGood::CATE_GAME
            : ShopGood::CATE_COURSE;
        $list = ShopGood::where('cate', $cate)
            ->where(function ($query) use ($label_str) {
                if ($label_str) {
                    $label = strtolower($label_str) === ShopGood::LABEL_TEJIAO
                        ? ShopGood::LABEL_TEJIAO
                        : ShopGood::LABEL_REXIAO;
                    $query->whereRaw('FIND_IN_SET(?, label)', [$label]);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(6);

        $list->map(function ($item) {
            $item->cate = $this->returnCateTxt($item['cate']);
            $item->label_arr = $this->returnLabelArr($item['label']);
            return $item;
        });
        return $list;
    }

    /**
     * -------------------------------------------------后台展示的商品列表
     *
     * @param array $search_data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listByAdmin($search_data)
    {
        $list = ShopGood::where(function ($query) use ($search_data) {
            $title = $search_data['title'] ?? '';
            $cate = $search_data['cate'] ?? '';
            $label = $search_data['label'] ?? '';
            if ($title) {
                $query->where('title', 'like', "%{$title}%");
            }
            if ($cate) {
                $query->where('cate', $cate);
            }
            if ($label) {
                $query->whereRaw('FIND_IN_SET(?, label)', [$label]);
            }
        })
            ->orderBy('id', 'desc')
            ->paginate(10);
        $list->map(function ($item) {
            $item->cate_txt = $this->returnCateTxt($item->cate);
            $item->label_arr = $this->returnLabelArr($item->label);
            return $item;
        });
        return $list;
    }

    /**
     * -------------------------------------------------新增或修改商品
     *
     * @param ShopGood|array $data_good
     * @param array $input_data
     * @return bool
     */
    public function editGood($data_good, $input_data)
    {
        if (!$data_good) {
            $data_good = new ShopGood();
        }
        $label = $input_data['label'] ?? [];
        $data_good->title = $input_data['title'];
        $data_good->title_sub = $input_data['title_sub'];
        $data_good->cover = $input_data['cover'];
        $data_good->amount = $input_data['amount'];
        $data_good->cate = $input_data['cate'];
        $data_good->label = implode(',',  $label);
        $rs = $data_good->save();
        return $rs;
    }

    /**
     * -------------------------------------------------订单商品
     *
     * @param ShopOrder $data_order
     * @return bool
     */
    public function goodDel($data_good)
    {
        $rs = $data_good->delete();
        return $rs;
    }

    /**
     * -------------------------------------------------检查支持的商品分类值
     *
     * @param int $val
     * @return bool
     */
    public function checkCate($val)
    {
        $cate_in = array_keys(ShopGood::cateRel());
        return in_array($val, $cate_in);
    }

    /**
     * -------------------------------------------------检查支持的商品标签值
     *
     * @param array $arr
     * @return bool
     */
    public function checkLabelArr($arr)
    {
        $label_in = array_keys(ShopGood::labelRel());
        $arr = array_values(array_filter($arr));
        foreach ($arr as $val_item) {
            if (!in_array($val_item, $label_in)) {
                return false;
            }
        }
        return true;
    }

    /**
     * -------------------------------------------------检查支持的商品标签值
     *
     * @param string $val
     * @return bool
     */
    public function checkLabel($val)
    {
        $label_in = array_keys(ShopGood::labelRel());
        $val_arr = explode(',', $val);
        $val_arr = array_values(array_filter($val_arr));
        foreach ($val_arr as $val_item) {
            if (!in_array($val_item, $label_in)) {
                return false;
            }
        }
        return true;
    }

    /**
     * -------------------------------------------------检查图片文件大小
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool
     */
    public function checkPicSize($file)
    {
        $size = $file->getSize();
        return $size <= 2 * 1024 * 1024;
    }

    /**
     * -------------------------------------------------上传图片文件
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function uploadPic($file)
    {
        if (!$file->isValid()) {
            return [
                'code' => 1, 'msg' => '上传不成功',
            ];
        }
    
        $disk = 'img';
        $relativePath = '/uploads/img/cover/' . $file->hashName(); // 相对路径
        $path = $file->storeAs('cover', $file->hashName(), ['disk' => $disk]); // 使用相对路径保存
    
        $data_re = [
            'url' => $relativePath, // 使用相对路径
        ];
    
        return [
            'code' => 0, 'data' => $data_re,
        ];
    }
    

}
