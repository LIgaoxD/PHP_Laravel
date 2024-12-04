<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard($guard)->check()) {
            if (! $request->expectsJson()) {
                return redirect('/admin/index')->with('toastr_info', '已经登录后台！');
            }

            return response()->json([
                'code' => 10, 'msg' => '已经登录后台！',
            ]);
        }

        return $next($request);
    }
}
