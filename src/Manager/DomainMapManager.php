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


use Zagovorichev\Laravel\Languages\LanguageManagerException;

class DomainMapManager extends RequestManager
{

    private $redirectPath = false;

    protected function getModeName()
    {
        return 'domainMap';
    }

    public function has()
    {
        return !!$this->get();
    }

    public function get()
    {
        $lang = false;
        $url = $this->request->url();
        foreach ($this->getConfig()->get('domainMap') as $_lang => $domain) {
            if (mb_strpos($url, $domain) !== false) {
                $lang = $_lang;
                break;
            }
        }
        return $lang;
    }

    public function set($lang = '')
    {
        $map = $this->getConfig()->get('domainMap');
        // don't do anything leave it for another storages
        if (!isset($map[$lang]) || !isset($map[$this->get()])) {
            return false;
        }

        $oldDomain = $map[$this->get()];
        $newDomain = $map[$lang];

        $this->redirectPath = str_replace($oldDomain, $newDomain, $this->request->url());
    }

    public function getRedirectPath()
    {
        return $this->redirectPath;
    }
}
