<?php
/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * MIT Public License for more details.
 *
 * Copyright (c) 2016. (original work)
 *
 * @author A.Zagovorichev <zagovorichev@gmail.com>
 */

namespace Zagovorichev\Laravel\Languages\Http\Middleware;


use Closure;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;
use Zagovorichev\Laravel\Languages\LanguageManager;

class LanguagesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request +
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $languageManager = new LanguageManager(new Repository(config('languages')));
        if ($languageManager->isOtherLanguage()) {
            Log::info('Languages middleware redirects app to the new language');
            return redirect($languageManager->getRedirectPath())
                ->withCookie($languageManager->getCookie());
        }

        if ($languageManager->has()) {
            \App::setLocale($languageManager->get());
        }

        return $next($request);
    }
}
