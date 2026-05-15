<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Apitoken {

    public function handle($request, Closure $next) {
        $token = $request->header('x-api-token') ?? null;

        if (!$token) {
            $request['loginuser'] = '';
        } else {
            $user = \App\Models\User::where('api_token', $token)->first();
            if ($user) {
                $request['loginuser'] = $user->toArray();
            } else {
                return Response()->json('unauthorized');
            }
        }
        return $next($request);
    }

}
