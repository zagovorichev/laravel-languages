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
use Zagovorichev\Laravel\Languages\LanguageManagerInterface;
use Zagovorichev\Laravel\Languages\Manager\CookieManager;
use Zagovorichev\Laravel\Languages\Manager\PathManager;
use Zagovorichev\Laravel\Languages\Manager\RequestManager;
use Zagovorichev\Laravel\Languages\Manager\SessionManager;
use Zagovorichev\Laravel\Languages\tests\mocks\CookieMock;
use Zagovorichev\Laravel\Languages\tests\mocks\RequestMock;
use Zagovorichev\Laravel\Languages\tests\mocks\SessionMock;

require_once "./mocks/cookie.php";

class ManagersTest extends \PHPUnit_Framework_TestCase
{
    private function managerTest(LanguageManagerInterface $manager)
    {
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());
        $manager->set('fr');
        $this->assertEquals('fr', $manager->get());
        $this->assertTrue($manager->has());
    }

    public function testManagers()
    {
        $managers = [];
        $conf = new Repository([]);
        $managers[] = new SessionManager($conf, new SessionMock() );
        $managers[] = new CookieManager($conf, CookieMock::class );

        foreach ($managers as $manager) {
            $this->managerTest($manager);
        }
    }

    public function testRequestManager()
    {
        $mock = new RequestMock();

        $manager = new RequestManager( $mock );
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());

        $mock->storage[LanguageManagerInterface::LANG] = 'fr';
        $this->assertTrue($manager->has());
        $this->assertEquals('fr', $manager->get());
    }

    public function testPathManager()
    {
        $mock = new RequestMock();

        // RegEx from configuration file
        $reg = 'http://www.example.com/{\w+}/';

        $manager = new PathManager($mock);
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());
    }
}
