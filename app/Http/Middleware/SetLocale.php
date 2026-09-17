<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $default = config('site.default_locale', 'es');
        $locale = $request->is('en', 'en/*') ? 'en' : $default;

        app()->setLocale($locale);

        $response = $next($request);

        if (method_exists($response, 'withCookie')) {
            return $response->withCookie(cookie(
                config('site.locale_cookie'),
                $locale,
                config('site.locale_cookie_minutes'),
            ));
        }

        return $response;
    }
}
