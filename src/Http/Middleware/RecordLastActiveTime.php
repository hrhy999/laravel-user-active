<?php

namespace Cblink\ActiveUser\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RecordLastActiveTime
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
        if (Auth::check()) {
            Auth::user()->recordLastActiveAt();
        }

        return $next($request);
    }
}