<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!Auth::Check() || (Auth::User()->active != "yes" || Auth::User()->type != "admin")) {
            if (Auth::Check()) {
                Auth::logout();
            }
            
            return redirect('admin/login');
        }
        return $next($request);
    }

}
