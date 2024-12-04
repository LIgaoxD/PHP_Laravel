<?php

namespace App\Http\Middleware;

use App\Repository\UserRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFrontStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        $userRepo = new UserRepository();
        $user = Auth::guard($guard)->user();
        if ($user && $userRepo->isStatusNo($user->status)) {
            // if (! $request->expectsJson()) {
            //     return redirect('/')->with('toastr_info', '用户已被禁用，无法操作！');
            // }

            return response()->json([
                'code' => 10, 'msg' => '用户已被禁用，无法操作！',
            ]);
        }

        return $next($request);
    }
}
