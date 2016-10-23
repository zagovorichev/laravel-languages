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
use Zagovorichev\Laravel\Languages\Manager\PathManager;
use Zagovorichev\Laravel\Languages\Manager\RequestManager;
use Zagovorichev\Laravel\Languages\Manager\SessionManager;


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
        'cookie',
    ];

    /**
     * LanguageManager constructor.
     * @param $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct($config);

        if ($this->getConfig()->has('modes')) {
            $this->modes = $this->sortModes($this->getConfig()->get('modes'));
        }
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

    private $managers = [];

    /**
     * @param $key
     * @return Manager
     */
    private function getManager($key)
    {
        if (!isset($this->managers[$key])) {
            $alias = $this->managersAliases[$key];

            /** @var Manager $manager */
            $this->managers[$key] = new $alias($this->getConfig());
        }

        return $this->managers[$key];
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

    protected function filterLang($lang)
    {
        $lang = parent::filterLang($lang);
        return $lang ? $lang : $this->getDefaultLanguage();
    }

    public function set($lang = '')
    {
        $lang = $this->filterLang($lang);

        foreach ($this->modes as $mode) {
            if ($mode == 'request') {
                continue;
            }
            $this->getManager($mode)->set($lang);
        }
    }

    public function has()
    {
        $lang = false;
        foreach ($this->modes as $mode) {
            $lang = $this->getManager($mode)->has();
            if ($lang) {
                break;
            }
        }

        return $lang;
    }

    public function getRedirectPath()
    {
        $domain = $this->getManager('domain')->getRedirectPath();
        $path = $this->getManager('path')->getRedirectPath();
        $request = $this->getManager('request')->getRedirectPath();

        return $domain . $path . $request;
    }
}
