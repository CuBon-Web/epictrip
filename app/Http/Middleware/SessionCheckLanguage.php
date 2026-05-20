<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class SessionCheckLanguage
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
        $supportedLanguages = ['en-US', 'es-ES'];
        $defaultLanguage = config('app.locale', 'es-ES');

        if (!in_array(Session::get('locale'), $supportedLanguages, true)) {
            Session::put('locale', $defaultLanguage);
        }

        if (!in_array(Session::get('localelang'), $supportedLanguages, true)) {
            Session::put('localelang', $defaultLanguage);
        }

        return $next($request);
    }
}
