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

    private $app;

    /**
     * LanguageManager constructor.
     * @param $config
     * @param $app
     */
    public function __construct($config, $app)
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

        // define application
        if (isset($app)) {
            $this->app = $app;
        } elseif (function_exists('app')) {
            // try to define current application
            // without application can't work anything
            $this->app = app();
        }
    }

    public function getLanguage()
    {
        $lang = $this->defaultLanguage;

        //session() => app('session)
        if (in_array('session', $this->modes) && $this->app['session']->has('lang')) {
            $lang = $this->app['session']->get('lang');
        } elseif (in_array('cookie', $this->modes) && $this->app['request']->cookie('lang', null)) {
            $lang = $this->app['request']->cookie('lang', $this->defaultLanguage);
        }

        //Cookie
        //app('request')->cookie('lang', null);
        //app('request')->cookie('lang', default);

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
