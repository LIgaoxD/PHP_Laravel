<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
        if (!Auth::guard($guard)->check()) {
            if (! $request->expectsJson()) {
                return redirect('/login')->with('toastr_info', '检测到尚未登录！');
            }

            return response()->json([
                'code' => 9, 'msg' => '检测到尚未登录！',
            ]);
        }

        return $next($request);
    }
}
