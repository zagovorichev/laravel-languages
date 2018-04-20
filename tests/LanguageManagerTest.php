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
use PHPUnit\Framework\TestCase;
use Zagovorichev\Laravel\Languages\LanguageManager;
use Zagovorichev\Laravel\Languages\LanguageManagerInterface;
use Zagovorichev\Laravel\Languages\Manager\DomainManager;
use Zagovorichev\Laravel\Languages\Manager\PathManager;
use Zagovorichev\Laravel\Languages\tests\mocks\CookieMock;
use Zagovorichev\Laravel\Languages\tests\mocks\RequestMock;
use Zagovorichev\Laravel\Languages\tests\mocks\SessionMock;

require_once __DIR__ . "/mocks/cookie.php";

class LanguageManagerTest extends TestCase
{

    private $session;

    private $cookie;

    private $config;

    private $request;

    public function setUp()
    {
        parent::setUp();

        CookieMock::clean();

        $this->session = new SessionMock();
        $this->cookie = CookieMock::class;
        $this->request = new RequestMock();

        $this->config = new Repository();
        $this->config->set('session', $this->session);
        $this->config->set('cookie', $this->cookie);
        $this->config->set('request', $this->request);
        $this->config->set('languages', ['en', 'es', 'ua', 'de', 'az', 'ge', 'eg', 'ch', 'it']);
    }

    /**
     * test default language
     */
    public function testGetLanguageWithoutConfig()
    {
        $languageManager = new LanguageManager($this->config);
        $this->assertEquals('en', $languageManager->get());
    }

    public function testDomainLanguage()
    {
        $this->config->set('modes', [
            'cookie',
            'domain',
            'session',
        ]);

        $this->request->setUrl('http://es.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2,
            'separator' => '.',
        ]);

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());
        $this->assertEquals('es', $languageManager->get());
    }

    public function testGetLanguageFromPath()
    {
        $this->config->set('modes', [
            'cookie',
            'path',
            'domain',
            'session',
        ]);

        $this->request->setUrl('http://es.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $this->request->setPath('ua/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());
        $this->assertEquals('ua', $languageManager->get());
    }

    public function testGetLanguageFromCookie()
    {
        $this->config->set('modes', [
            'cookie',
            'path',
            'domain',
            'session',
        ]);

        $this->request->setUrl('http://es.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $this->request->setPath('ua/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        cookie(LanguageManagerInterface::LANG, 'ch');

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());
        $this->assertEquals('ch', $languageManager->get());
    }

    public function testGetLanguageFromSession()
    {
        $this->config->set('modes', [
            'cookie',
            'path',
            'domain',
            'session',
        ]);

        $this->request->setUrl('http://es.example.com/something/else');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $this->request->setPath('ua/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        cookie(LanguageManagerInterface::LANG, 'ch');

        $this->session->put(LanguageManagerInterface::LANG, 'de');

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());
        $this->assertEquals('de', $languageManager->get());
    }

    public function testSetNewLanguage()
    {
        $this->config->set('modes', [
            'cookie',
            'path',
            'domain',
            'session',
            'request',
            'domainMap',
        ]);

        $this->request->setUrl('http://es.example.com/');

        // RegEx from configuration file
        $this->config->set('domainRegExp', [
            'reg' => '|^(http://)([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
            'langPart' => 2,
            'separator' => '.',
        ]);

        $this->request->setPath('ua/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        // Can't use both of the domain and domainMap (for now it haven't any sense)
        $this->config->set('domainMap', [
            'it' => 'it.example.com',
            'es' => 'es.example.com',
            'az' => 'vvv.another.az',
        ]);

        cookie(LanguageManagerInterface::LANG, 'ch');

        $this->session->put(LanguageManagerInterface::LANG, 'de');

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());

        $this->assertEquals('de', $this->session->get(LanguageManagerInterface::LANG, false));
        $this->assertEquals('ch', call_user_func([$this->cookie, 'get'], LanguageManagerInterface::LANG, false));

        $pathManager = new PathManager($this->config, $this->request);
        $this->assertEquals('ua', $pathManager->get());

        $domainManager = new DomainManager($this->config, $this->request);
        $this->assertEquals('es', $domainManager->get());

        $languageManager->set('it');

        $this->assertEquals('it', $this->session->get(LanguageManagerInterface::LANG, false));
        $this->assertEquals('it', call_user_func([$this->cookie, 'get'], LanguageManagerInterface::LANG, false));

        $this->assertEquals('http://it.example.com/it/bar/foo?param1=1&param2=2', $languageManager->getRedirectPath());

        $languageManager->set('az');

        $this->assertEquals('az', $this->session->get(LanguageManagerInterface::LANG, false));
        $this->assertEquals('az', call_user_func([$this->cookie, 'get'], LanguageManagerInterface::LANG, false));

        $this->assertEquals('http://vvv.another.az/az/bar/foo?param1=1&param2=2', $languageManager->getRedirectPath());
    }
}
