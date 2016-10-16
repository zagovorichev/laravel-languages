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


use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    const CONFIG_FILENAME = 'ide-helper.php';

    /**
     * @var string
     */
    private $defaultConfigPath;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->defaultConfigPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME;
    }

    public function boot()
    {
        $this->publishes([$this->defaultConfigPath => $this->basePath()], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom($this->defaultConfigPath, self::CONFIG_FILENAME);

        $this->registerArtisanCommands();


        $this->app->singleton('languages', function ($app) {

            $locale = $app['config']['app.locale'];
            $manager = new LanguageManager();
            //$trans->setFallback($app['config']['app.fallback_locale']);

            return $manager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['languages'];
    }

    private function basePath()
    {
        $pubPath = '';
        if (function_exists('config_path')) {
            $pubPath = config_path(self::CONFIG_FILENAME);
        } elseif (function_exists('base_path')) {
            $pubPath = base_path('config/' . self::CONFIG_FILENAME);
        }

        return $pubPath;
    }
}
