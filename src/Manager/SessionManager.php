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

namespace Zagovorichev\Laravel\Languages\Manager;


use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Session;
use Zagovorichev\Laravel\Languages\LanguageManagerException;

class SessionManager extends Manager
{
    /**
     * @var Session
     */
    private $session;

    protected function getModeName()
    {
        return 'session';
    }

    public function __construct(Repository $config, $session = null)
    {
        parent::__construct($config);

        if ($session) {
            $this->session = $session;
        } elseif ($this->getConfig()->has('session')) {
            $this->session = $this->getConfig()->get('session');
        } elseif(function_exists('session')) {
            $this->session = session();
        } else {
            throw new LanguageManagerException('Session did not specified [specify it through config or use session() method]');
        }
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
