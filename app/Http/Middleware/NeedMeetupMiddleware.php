<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NeedMeetupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $request->user()->load('meetups');
            if ($request->user()->meetups->count() < 1) {
                return redirect()->setIntendedUrl($request->url())->route('profile.meetups');
            }
        }

        return $next($request);
    }
}
