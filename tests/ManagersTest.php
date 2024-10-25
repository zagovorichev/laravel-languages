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

declare(strict_types=1);

namespace Zagovorichev\Laravel\Languages\tests;


use Illuminate\Config\Repository;
use PHPUnit\Framework\TestCase;
use Zagovorichev\Laravel\Languages\LanguageManagerException;
use Zagovorichev\Laravel\Languages\LanguageManagerInterface;
use Zagovorichev\Laravel\Languages\Manager\CookieManager;
use Zagovorichev\Laravel\Languages\Manager\DomainManager;
use Zagovorichev\Laravel\Languages\Manager\DomainMapManager;
use Zagovorichev\Laravel\Languages\Manager\PathManager;
use Zagovorichev\Laravel\Languages\Manager\RequestManager;
use Zagovorichev\Laravel\Languages\Manager\SessionManager;
use Zagovorichev\Laravel\Languages\tests\mocks\CookieMock;
use Zagovorichev\Laravel\Languages\tests\mocks\RequestMock;
use Zagovorichev\Laravel\Languages\tests\mocks\SessionMock;

require_once __DIR__ . "/mocks/cookie.php";

class ManagersTest extends TestCase
{
    private Repository $config;

    public function setUp(): void
    {
        parent::setUp();

        $this->config = new Repository([]);
        CookieMock::clean();
    }

    private function managerTest(LanguageManagerInterface $manager)
    {
        $this->assertFalse($manager->has());
        $this->assertFalse($manager->get());
        $manager->set('fr');
        $this->assertEquals('fr', $manager->get());
        $this->assertTrue($manager->has());
    }

    /**
     * @throws LanguageManagerException
     */
    public function testSessionManager()
    {
        $manager = new SessionManager($this->config, new SessionMock() );
        $this->managerTest($manager);
    }

    /**
     * @throws LanguageManagerException
     */
    public function testCookieManager()
    {
        $manager = new CookieManager($this->config, CookieMock::class );
        $this->managerTest($manager);
    }

    /**
     * @throws LanguageManagerException
     */
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
     * @throws LanguageManagerException
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
        $this->assertEquals('es/bar/foo', $manager->getRedirectPath());
    }

    /**
     * @throws LanguageManagerException
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
        $this->assertEquals('posts/es/12345/art', $manager->getRedirectPath());
    }

    /**
     * @throws LanguageManagerException
     */
    public function testDomainManager()
    {
        $mock = new RequestMock();
        $mock->setUrl('http://en.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2,
            'separator' => '.',
        ]);

        $manager = new DomainManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
        $this->assertEquals('http://es.example.com/something/else', $manager->getRedirectPath());
    }

    /**
     * @throws LanguageManagerException
     */
    public function testDomainManager2()
    {
        $mock = new RequestMock();
        $mock->setUrl('http://province.en.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://province\.)([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2,
            'separator' => '.',
        ]);

        $manager = new DomainManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
        $this->assertEquals('http://province.es.example.com/something/else', $manager->getRedirectPath());
    }

    /**
     * @throws LanguageManagerException
     */
    public function testDomainMapManager()
    {
        $mock = new RequestMock();
        $mock->setUrl('http://www.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainMap', [
            'en' => 'www.example.com',
            'es' => 'es.example.com',
            'ua' => 'www.example.ua',
        ]);

        $manager = new DomainMapManager($this->config, $mock);
        $this->assertTrue($manager->has());
        $this->assertEquals('en', $manager->get());
        $manager->set('es');
        $this->assertEquals('http://es.example.com/something/else', $manager->getRedirectPath());
    }
}
