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

namespace Zagovorichev\Laravel\Languages;


use Illuminate\Config\Repository;

interface LanguageManagerInterface
{
    const LANG = 'lang';

    /**
     * @return bool
     */
    public function has();

    /**
     * @return string
     */
    public function get();

    /**
     * @param string $lang
     */
    public function set($lang = '');

    /**
     * If redirect needed for the manager
     * @return string | false
     */
    public function getRedirectPath();
}
