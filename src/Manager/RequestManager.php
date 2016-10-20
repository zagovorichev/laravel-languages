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

    private $request;

    public function __construct(Repository $config, $request)
    {
        parent::__construct($config);

        $this->request = $request;
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
}
