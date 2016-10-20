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

namespace Zagovorichev\Laravel\Languages\Manager;


use Illuminate\Support\Facades\Cookie;

class CookieManager extends Manager
{
    /**
     * @var Cookie
     */
    private $cookie;

    public function __construct($config, $cookie)
    {
        parent::__construct($config);

        $this->cookie = $cookie;
    }

    public function get()
    {
        return call_user_func([$this->cookie, 'get'], self::LANG, false);
    }

    public function set($lang = '')
    {
        if (function_exists('cookie')) {
            cookie(self::LANG, $lang);
        }
    }

    public function has()
    {
        return call_user_func([$this->cookie, 'has'], self::LANG);
    }
}
