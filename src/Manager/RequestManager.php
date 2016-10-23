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
use Zagovorichev\Laravel\Languages\LanguageManagerException;

class RequestManager extends Manager
{

    protected $request;

    public function __construct(Repository $config, $request = null)
    {
        parent::__construct($config);

        if ($request) {
            $this->request = $request;
        } elseif ($this->getConfig()->has('request')) {
            $this->request = $this->getConfig()->get('request');
        } elseif(function_exists('request')) {
            $this->request = request();
        } else {
            throw new LanguageManagerException('Request did not specified [specify it through config or use session() method]');
        }
    }

    public function has()
    {
        return $this->request->has(self::LANG);
    }

    public function get()
    {
        return $this->request->input(self::LANG, false);
    }

    public function set($lang = '')
    {
        throw new LanguageManagerException('Request data can\'t be set from backend');
    }

    public function getRedirectPath()
    {
        $params = $this->request->except(['lang']);
        return '?' . http_build_query($params);
    }
}
