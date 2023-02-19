<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetTimezoneForNovaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(Cookie::get('lang') ?: config('app.locale'));
        if ($request->user()
            && $timezone = $request->user()->timezone
        ) {
            config([
                'app.user-timezone' => $timezone,
            ]);

            return $next($request);
        }

        return $next($request);
    }
}
