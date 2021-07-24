<?php

namespace App\Http\Middleware;

use Closure;

class adminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!(isset($_COOKIE[sha1('admin_logged_in')]))){
            //echo 'a';
            return redirect(url('admin/login'));
            // echo '1';
            // return $next($request);
        }
        return $next($request);
    }
}
