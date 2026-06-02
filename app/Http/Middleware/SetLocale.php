<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next, string $locale = 'en'): Response
    {
        if (in_array($locale, ['en', 'hi'])) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
