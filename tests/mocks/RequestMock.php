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


class RequestMock
{
    public $storage = [];
    public function input($name, $default){
        return isset($this->storage[$name]) ? $this->storage[$name] : $default;
    }
    public function has($name){
        return isset($this->storage[$name]);
    }

    // 'en/bar/foo'
    private $path = '';

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function path()
    {
        return $this->path;
    }


    // 'http://en.example.com/something/else'
    private $url = '';

    public function setUrl($url = '')
    {
        return $this->url = $url;
    }

    public function url()
    {
        return $this->url;
    }

    public function except()
    {
        return ['param1' => '1', 'param2' => 2];
    }
}
