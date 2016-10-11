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

namespace Zagovorichev\Laravel\Languages;


class LanguageManager
{
    private $defaultLanguage = 'en';

    public function __construct()
    {
        $config = config('');
        //$this->defaultLanguage =
    }

    public function getLanguage()
    {
        return $lang;
    }

    public function setLanguage($lang)
    {
        $currentLang ==$this->getLanguage();

            session()->put('lang', $lang);
            cookie('lang', $lang);

            \App::setLocale($lang);

        $path = $request->path();
        $params = $request->except(['lang']);
        if (count($params)) {
            $path .= '?' .  http_build_query($params);
        }

        return redirect($path);
    }
}
