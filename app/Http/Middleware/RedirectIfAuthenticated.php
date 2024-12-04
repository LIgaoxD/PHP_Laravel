<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            if (! $request->expectsJson()) {
                return redirect('/my/index')->with('toastr_info', '已经登录！');
            }

            return response()->json([
                'code' => 10, 'msg' => '已经登录！',
            ]);
        }

        return $next($request);
    }
}
