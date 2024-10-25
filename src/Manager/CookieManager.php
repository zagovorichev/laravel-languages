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

namespace Zagovorichev\Laravel\Languages\Manager;


use Illuminate\Support\Facades\Cookie;
use Zagovorichev\Laravel\Languages\LanguageManagerException;

class CookieManager extends Manager
{
    /**
     * @var Cookie
     */
    private $cookie;

    private $tmpLangCookie = null;

    public function __construct($config, $cookie = null)
    {
        parent::__construct($config);

        if ($cookie) {
            $this->cookie = $cookie;
        } elseif ($this->getConfig()->has('cookie')) {
            $this->cookie = $this->getConfig()->get('cookie');
        } elseif(function_exists('cookie')) {
            $this->cookie = Cookie::class;
        } else {
            throw new LanguageManagerException('Cookie did not specified [specify it through config or use cookie() method]');
        }
    }

    protected function getModeName()
    {
        return 'cookie';
    }


    public function get()
    {
        return $this->tmpLangCookie ?? call_user_func([$this->cookie, 'get'], self::LANG, false);
    }

    public function set($lang = '')
    {
        $this->tmpLangCookie = $lang;
    }

    public function has()
    {
        return $this->tmpLangCookie !== null || call_user_func([$this->cookie, 'has'], self::LANG);
    }

    public function getLangCookie()
    {
        return Cookie::make(self::LANG, $this->get());
    }
}
