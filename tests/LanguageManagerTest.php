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
use Zagovorichev\Laravel\Languages\tests\mocks\CookieMock;
use Zagovorichev\Laravel\Languages\tests\mocks\RequestMock;
use Zagovorichev\Laravel\Languages\tests\mocks\SessionMock;

class LanguageManagerTest extends \PHPUnit_Framework_TestCase
{

    private $session;

    private $cookie;

    private $config;

    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->session = new SessionMock();
        $this->cookie = CookieMock::class;
        $this->request = new RequestMock();

        $this->config = new Repository();
        $this->config->set('session', $this->session);
        $this->config->set('cookie', $this->cookie);
        $this->config->set('request', $this->request);
        $this->config->set('languages', ['en','es', 'ua']);
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
            'reg' => '|^(http://)([a-z]{2})(\.example\.com.*)$|ui',
            'langPart' => 2
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
            'reg' => '|^(http://)([a-z]{2})(\.example\.com.*)$|ui',
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
            'reg' => '|^(http://)([a-z]{2})(\.example\.com.*)$|ui',
            'langPart' => 2
        ]);

        $this->request->setPath('ua/bar/foo');

        // RegEx from configuration file
        $this->config->set('pathRegExp', [
            'reg' => '|([a-z]{2})(/.*)|ui',
            'langPart' => 1,
        ]);

        $this->cookie->put('lang', 'ch');

        $languageManager = new LanguageManager($this->config);
        $this->assertTrue($languageManager->has());
        $this->assertEquals('ua', $languageManager->get());
    }

    public function testGetLanguageFromSession()
    {
    }

    public function testGetLanguageFromRequest()
    {
    }
}
