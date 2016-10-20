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

namespace Zagovorichev\Laravel\Languages\tests;


use Illuminate\Config\Repository;
use Zagovorichev\Laravel\Languages\LanguageManager;

class LanguageManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test default language
     */
    public function testGetLanguageWithoutConfig()
    {
        $conf = new Repository();
        $languageManager = new LanguageManager($conf);
        $this->assertEquals('en', $languageManager->get());
    }

    public function testGetLanguageFromSession()
    {
    }

    public function testGetLanguageFromCookie()
    {
    }

    public function testGetLanguageFrom()
    {
    }

}
