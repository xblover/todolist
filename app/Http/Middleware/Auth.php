<?php

namespace App\Http\Middleware;

use App\Token\TokenManager;
use Closure;

class Auth
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
        $header = $request->header('Authorization');
        $token = substr($header,7);

        if (!app(TokenManager::class)->checkToken($token)) {
            return response('',401);
        }

        return $next($request);
    }
}
