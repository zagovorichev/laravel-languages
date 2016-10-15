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


use Zagovorichev\Laravel\Languages\LanguageManager;

class LanguageManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetLanguage()
    {
        $manager = new LanguageManager();
        $this->assertEquals('en', $manager->getLanguage());
    }
}
