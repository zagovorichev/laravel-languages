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

class PathManager extends RequestManager
{
    private $path = '';

    protected function getResource()
    {
        return $this->request->path();
    }

    protected function getRegExp()
    {
        return $this->getConfig()->get('pathRegExp', '');
    }

    public function get()
    {
        $lang = false;
        if (preg_match($this->getRegExp()['reg'], $this->getResource(), $match) !== false) {
            if (isset($match[$this->getRegExp()['langPart']])) {
                $lang = $this->filterLang($match[$this->getRegExp()['langPart']]);
            }
        }

        return $lang;
    }

    /**
     * Replace part of the url with new language
     * @param string $lang
     * @throws LanguageManagerException
     */
    public function set($lang = '')
    {
        $path = '';
        if (preg_match($this->getRegExp()['reg'], $this->getResource(), $matches) !== false) {
            foreach ($matches as $key => $match) {
                if (!$key) {
                    continue;
                }
                $path .= ($key == $this->getRegExp()['langPart']) ? $lang : $match;
            }
        }

        $this->path = $path;
    }

    public function getRedirectPath()
    {
        return $this->path;
    }

    public function has()
    {
        return !!$this->get();
    }
}
