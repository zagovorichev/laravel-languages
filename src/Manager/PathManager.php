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
        $regEx = $this->getConfig()->get('pathRegExp', '');
        if ($d = preg_match('|'. $regEx . '|ui', $this->request->path(), $match) !== false) {
            $lang = $this->detectLang($match[1]);
        }

        return $lang;
    }

    /**
     * Replace part of the url with new language
     * @param string $lang
     */
    public function set($lang = '')
    {
        if (preg_match($this->getConfig()->get('pathRegExp', ''), $this->request->path(), $match) !== false) {
            $path = preg_replace('{\w+}', $lang, $this->getConfig()->get('pathRegEx', ''));
        }
    }

    public function has()
    {
        return !!$this->get();
    }
}