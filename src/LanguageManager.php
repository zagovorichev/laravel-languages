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


use Illuminate\Config\Repository;
use Zagovorichev\Laravel\Languages\Manager\CookieManager;
use Zagovorichev\Laravel\Languages\Manager\DomainManager;
use Zagovorichev\Laravel\Languages\Manager\Manager;
use Zagovorichev\Laravel\languages\Manager\PathManager;
use Zagovorichev\Laravel\languages\Manager\RequestManager;
use Zagovorichev\Laravel\languages\Manager\SessionManager;


/**
 * Provides managing for the different languages
 *
 * Class LanguageManager
 * @package Zagovorichev\Laravel\Languages
 */
class LanguageManager extends Manager
{
    /**
     * If user selected new language, then we need to replace all things assigned to it (all other modes)
     * else if we can find language in session - we must use it
     * else if ...
     * else if we found language in domain - use it
     * else use default language
     *
     * @var array
     */
    protected $modesPriority = [
        'request', // high priority
        'session',
        'cookie',
        'path',
        'domain', // low priority

    ];

    /**
     * Aliases for the language managers
     * @var array
     */
    private $managersAliases = [
        'request' => RequestManager::class,
        'session' => SessionManager::class,
        'cookie' => CookieManager::class,
        'path' => PathManager::class,
        'domain' => DomainManager::class,
    ];

    /**
     * Modes for the languages
     *
     * can be changed through configuration
     *
     * @var array
     */
    private $modes = [
        'session',
        'cookies',
    ];

    /**
     * LanguageManager constructor.
     * @param $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct($config);

        if ($this->getConfig()->has('modes')) {
            $this->setModes($this->getConfig()->get('modes'));
        }
    }

    private function setModes(array $modes)
    {
        $this->modes = $this->sortModes($modes);
        $this->checkModes();
    }

    private function sortModes($modes)
    {
        $sorted = [];
        foreach ($this->modesPriority as $mode) {
            if (in_array($mode, $modes)) {
                $sorted[] = $mode;
            }
        }

        return $sorted;
    }

    /**
     * Check modes and exclude modes which can't be used
     * (for example if not defined cookie() - we can't set lang in the cookie)
     */
    private function checkModes()
    {
        if (in_array('cookie', $this->modes) && !function_exists('cookie')) {
            unset($this->modes['cookie']);
            throw new LanguageManagerException('Function cookie() not defined (turn it on or switch off cookie mode)');
        }
    }

    /**
     * @param $key
     * @return Manager
     */
    private function getManager($key)
    {
        $alias = $this->managersAliases[$key];

        /** @var Manager $manager */
        $manager = new $alias;
        $manager->setConfig($this->getConfig());

        return $manager;
    }

    public function get()
    {
        $lang = false;
        foreach ($this->modes as $mode) {
            $lang = $this->getManager($mode)->get();
            if ($lang) {
                break;
            }
        }

        if (!$lang) {
            $lang = $this->getDefaultLanguage();
        }

        return $lang;
    }

    public function set($lang = '')
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

    public function has()
    {

    }
}
