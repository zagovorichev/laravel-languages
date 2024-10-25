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

namespace Zagovorichev\Laravel\Languages\tests\mocks;


class CookieMock
{
    private static $storage = [];

    public static function get($name, $default){
        return isset(self::$storage[$name]) ? self::$storage[$name] : $default;
    }
    public static function has($name){
        return isset(self::$storage[$name]);
    }

    // used only from cookie() func
    public static function put($name, $value)
    {
        self::$storage[$name] = $value;
    }
    public static function clean()
    {
        self::$storage = [];
    }
}
