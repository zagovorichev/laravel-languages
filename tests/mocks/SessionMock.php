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


class SessionMock
{
    private $storage = [];
    public function get($name, $default){
        return isset($this->storage[$name]) ? $this->storage[$name] : $default;
    }
    public function put($name, $value){
        $this->storage[$name] = $value;
    }
    public function has($name){
        return isset($this->storage[$name]);
    }
}