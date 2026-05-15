<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) {
        $found = \App\Models\Permission::where('group_id', \Auth::User()->group_id)->where('permission', $role)->count();
        if ($found == 0) {
            return redirect('admin/not_allow');
        }
        return $next($request);
    }

}
