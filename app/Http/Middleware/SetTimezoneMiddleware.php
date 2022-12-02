<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTimezoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            !collect($request->segments())->contains('nova')
            && $request->user()
            && $timezone = $request->user()->timezone
        ) {
            config(['app.timezone' => $timezone]);
        }
        config(['app.timezone' => 'Europe/Berlin']);

        return $next($request);
    }
}
