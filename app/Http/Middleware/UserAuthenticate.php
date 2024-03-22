<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null) {

        $uri = $request->path();
        $bypass_uri = array('logout');

        if (!in_array($uri, $bypass_uri)) {

            if ($uri == "user/login" || $uri == "user") {

                if (Auth::guard($guard)->check()) {
                    $request->session()->put('userid',Auth::user()->id);
                    return redirect('/');
                }
            } else {
                if (!Auth::guard($guard)->check()) {
                    //$request->session()->put('userid',Auth::user()->id);
                    return redirect('/user/login');
                }
            }
        }

        return $next($request);
    }
}
