<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommonRepository
{
    public function nameValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return $len >= 4 && $len <= 20;
    }

    public function nicknameValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return $len >= 4 && $len <= 20;
    }

    public function passwordValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return $len >= 4 && $len <= 20;
    }

    public function introValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return $len <= 200;
    }

    public function sexValid($str)
    {
        return in_array($str, [1, 2]);
    }

    public function goodTitleValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return  $len <= 50;
    }

    public function goodTitleSubValid($str)
    {
        $len = Str::length($str, 'utf-8');
        return  $len <= 100;
    }

    public function goodCoverValid($str)
    {
        return !!$str;
    }

    public function goodAmountValid($str)
    {
        return $str > 0 && round($str, 2) == floatval($str);
    }

    public function priceFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function dateTimeStr()
    {
        return date('Y-m-d H:i:s');
    }

    public function initAdminUser()
    {
        static $data;
        if (is_null($data)) {
            $data = Auth::guard('admin')->user();
        }
        return $data;
    }

    public function iniAdminUserId()
    {
        return $this->initAdminUser()->id ?? 0;
    }

    public function initUser()
    {
        static $data;
        if (is_null($data)) {
            $data = Auth::guard('web')->user();
        }
        return $data;
    }

    public function initUserId()
    {
        return $this->initUser()->id ?? 0;
    }
}
