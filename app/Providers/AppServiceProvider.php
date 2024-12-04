<?php

namespace App\Providers;

use App\Repository\ConfigRepository;
use App\Repository\GoodRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configRepo = new ConfigRepository();
        $goodRepo = new GoodRepository();
        View::composer('admin1.*', function ($view) use ($configRepo) {
            $admin_user = Auth::guard('admin')->user();
            $site_name = $configRepo->getConfig('site_name');

            $view->with('admin_user', $admin_user);
            $view->with('admin_user_id', $admin_user->id ?? 0);
            $view->with('request_path', request()->path());
            $view->with('site_name', $site_name);
        });

        View::composer('shop1.*', function ($view) use ($configRepo, $goodRepo) {
            $user = Auth::guard('web')->user();
            $site_name = $configRepo->getConfig('site_name');
            $user_id = $user->id ?? 0;
            $cart_num = $goodRepo->cartNum($user_id);
            $cart_num = $cart_num > 99 ? '99+' : $cart_num;

            $view->with('user', $user);
            $view->with('user_id', $user_id);
            $view->with('request_path', request()->path());
            $view->with('site_name', $site_name);
            $view->with('cart_num', $cart_num);
        });
    }
}
