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


use Illuminate\Config\Repository;
use Zagovorichev\Laravel\Languages\LanguageManagerInterface;


abstract class Manager implements LanguageManagerInterface
{
    /** @var \Illuminate\Config\Repository */
    private $config;

    /**
     * Allowed languages
     *
     * @var array
     */
    private $languages = ['en'];

    /**
     * If nothing defined yet, use default
     * @var string
     */
    private $defaultLanguage = 'en';

    /**
     * LanguageManager constructor.
     * @param $config
     */
    public function __construct(Repository $config)
    {
        $this->setConfig($config);

        if ($this->config->has('default_language')) {
            $this->setDefaultLanguage($this->config->get('default_language'));
        }

        if ($this->config->has('languages')) {
            $this->setLanguages($this->config->get('languages'));
        }
    }

    public function setConfig(Repository $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    protected function setDefaultLanguage($lang = '')
    {
        $this->defaultLanguage = $lang;
    }

    protected function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    private function setLanguages(array $languages)
    {
        $this->languages = array_unique($languages);
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function detectLang($lang)
    {
        if (!in_array($lang, $this->getLanguages())) {
            $lang = false;
        }

        return $lang;
    }
}
