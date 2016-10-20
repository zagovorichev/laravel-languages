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

namespace Zagovorichev\Laravel\Languages\tests\mocks;


class RequestMock
{
    public $storage = [];
    public function input($name, $default){
        return isset($this->storage[$name]) ? $this->storage[$name] : $default;
    }
    public function has($name){
        return isset($this->storage[$name]);
    }

    public function path()
    {
        return 'en/bar/foo';
    }
}