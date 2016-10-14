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


/**
 * Provides managing for the different languages
 *
 * Class LanguageManager
 * @package Zagovorichev\Laravel\Languages
 */
class LanguageManager
{
    /**
     * If nothing defined yet, use default
     * @var string
     */
    private $defaultLanguage = 'en';

    /** @var \Illuminate\Config\Repository */
    private $config;

    /**
     * Allowed languages
     *
     * @var array
     */
    private $languages = ['en'];

    /**
     * Modes for the languages
     *
     * can be changed through
     *
     * @var array
     */
    private $modes = [
        'session',
        'cookies'
    ];

    public function __construct($config)
    {
        $this->config = $config;

        if ($this->config->has('default_language')) {
            $this->defaultLanguage = $this->config->get('default_language');
        }

        if ($this->config->has('modes')) {
            $this->modes = $this->config->get('modes');
        }

        if ($this->config->has('languages')) {
            $this->languages = $this->config->get('languages');
        }
    }

    public function getLanguage()
    {
        $lang = $this->defaultLanguage;

/*
        // set correct locale
        if (session()->has('lang')) {
            $lang = session()->get('lang');
        } elseif (Cookie::has('lang')) {
            $lang = Cookie::get('lang');
        }*/

        return $lang;
    }

    /**
     * Set language
     *
     * @param $lang
     */
    public function setLanguage($lang)
    {
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



    }
}
