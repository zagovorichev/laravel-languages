<?php
/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * MIT Public License for more details.
 *
 * Copyright (c) 2016. (original work) Blog-Tree.com;
 *
 * @author A.Zagovorichev <zagovorichev@gmail.com>
 */

namespace zagovorichev\laravel\languages\Http\Middleware;


use Closure;

class LanguagesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request+
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        config('languages');

        /*$currentLang == $this->getLanguage();

                    session()->put('lang', $lang);
                    cookie('lang', $lang);

                    \App::setLocale($lang);

                $path = $request->path();
                $params = $request->except(['lang']);
                if (count($params)) {
                    $path .= '?' .  http_build_query($params);
                }

                return redirect($path);*/

    /*    protected function redirect($path='')
    {
        if (!function_exists('redirect')) {
            throw new LanguageManagerException('Function redirect() does not exists, can\'t go to the path ' . $path);
        }

        if (!empty($path) && function_exists('redirect')) {
            redirect($path);
        }
    }*/
        return $next($request);
    }
}
