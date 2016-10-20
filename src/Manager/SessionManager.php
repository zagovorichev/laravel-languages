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
use Illuminate\Support\Facades\Session;

class SessionManager extends Manager
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Repository $config, $session)
    {
        parent::__construct($config);

        $this->session = $session;
    }

    public function has()
    {
        return $this->session->has(self::LANG);
    }

    public function get()
    {
        return $this->session->get(self::LANG, false);
    }

    public function set($lang = '')
    {
        return $this->session->put(self::LANG, $lang);
    }
}
