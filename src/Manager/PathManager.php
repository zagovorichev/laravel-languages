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


use Illuminate\Config\Repository;

class PathManager extends Manager
{

    private $request;

    /**
     * PathManager constructor.
     * @param $request
     * @param $config
     */
    public function __construct(Repository $config, $request)
    {
        parent::__construct($config);

        $this->request = $request;
    }

    public function get()
    {
        $lang = false;
        if (preg_match($this->getConfig()->get('pathRegEx', ''), $this->request->path(), $match) !== false) {
            $lang = $match[1];
        }

        return $lang;
    }

    /**
     * Replace part of the url with new language
     * @param string $lang
     */
    public function set($lang = '')
    {
        if (preg_match($this->getConfig()->get('pathRegEx', ''), $this->request->path(), $match) !== false) {
            $path = preg_replace('{\w+}', $lang, $this->getConfig()->get('pathRegEx', ''));
        }
    }

    public function has()
    {
        // TODO: Implement has() method.
    }
}