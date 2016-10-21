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
use Zagovorichev\Laravel\Languages\Manager\DomainManager;
use Zagovorichev\Laravel\Languages\Manager\PathManager;
use Zagovorichev\Laravel\Languages\Manager\RequestManager;
use Zagovorichev\Laravel\Languages\Manager\SessionManager;
use Zagovorichev\Laravel\Languages\tests\mocks\CookieMock;
use Zagovorichev\Laravel\Languages\tests\mocks\RequestMock;
use Zagovorichev\Laravel\Languages\tests\mocks\SessionMock;

require_once "./mocks/cookie.php";

class ManagersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Repository
     */
    private $config;

    public function setUp()
    {
        parent::setUp();

        $this->config = new Repository([]);
    }

    private function managerTest(LanguageManagerInterface $manager)
    {
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());
        $manager->set('fr');
        $this->assertEquals('fr', $manager->get());
        $this->assertTrue($manager->has());
    }

    public function testCookieSessionManagers()
    {
        $managers = [];
        $managers[] = new SessionManager($this->config, new SessionMock() );
        $managers[] = new CookieManager($this->config, CookieMock::class );

        foreach ($managers as $manager) {
            $this->managerTest($manager);
        }
    }

    public function testRequestManager()
    {
        $mock = new RequestMock();

        $manager = new RequestManager($this->config, $mock );
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());

        $mock->storage[LanguageManagerInterface::LANG] = 'fr';
        $this->assertTrue($manager->has());
        $this->assertEquals('fr', $manager->get());
    }

    /**
     * @expectedException \Zagovorichev\Laravel\Languages\LanguageManagerException
     * @expectedExceptionMessage Function redirect() does not exists, can't go to the path es/bar/foo
     */
    public function testPathManager()
    {
        $mock = new RequestMock();
        $mock->setPath('en/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        $manager = new PathManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
    }

    /**
     * @expectedException \Zagovorichev\Laravel\Languages\LanguageManagerException
     * @expectedExceptionMessage Function redirect() does not exists, can't go to the path posts/es/12345/art
     */
    public function testPathManager2()
    {
        $mock = new RequestMock();
        $mock->setPath('posts/en/12345/art');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|^(posts/)([a-z]{2})(/.*)$|ui',
            'langPart' => 2
        ]);

        $manager = new PathManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
    }

    /**
     * @expectedException \Zagovorichev\Laravel\Languages\LanguageManagerException
     * @expectedExceptionMessage Function redirect() does not exists, can't go to the path http://es.example.com/something/else
     */
    public function testDomainManager()
    {
        $mock = new RequestMock();
        $mock->setUrl('http://en.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})(\.example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $manager = new DomainManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
    }

    /**
     * @expectedException \Zagovorichev\Laravel\Languages\LanguageManagerException
     * @expectedExceptionMessage Function redirect() does not exists, can't go to the path http://province.es.example.com/something/else
     */
    public function testDomainManager2()
    {
        $mock = new RequestMock();
        $mock->setUrl('http://province.en.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://province\.)([a-z]{2})(\.example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $manager = new DomainManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
    }
}
