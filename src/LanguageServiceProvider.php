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

namespace Zagovorichev\Laravel\Languages;


use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    const CONFIG_NAME = 'languages';

    /**
     * @var string
     */
    private $defaultConfigPath;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->defaultConfigPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . self::CONFIG_NAME . '.php';
    }

    public function register()
    {
        $this->mergeConfigFrom($this->defaultConfigPath, self::CONFIG_NAME);

        $this->app->singleton(LanguageManager::class, function ($app) {
            $conf = new Repository(config(self::CONFIG_NAME));
            $manager = new LanguageManager($conf);
            return $manager;
        });
    }

/*
 * TODO I must understand how I can place midleware into another group from the provider
 *
 * todo (then I can delete initialization from the app/Http/Kernel and I can use only provider initialization)
 *
 *
 *
 *     public function boot()
    {
        $this->publishes([$this->defaultConfigPath => $this->basePath()], 'config');

        $this->registerMiddleware(LanguagesMiddleware::class);
    }*/

    /**
     * Register the Languages Middleware should be in the web group
     * in other case we can't write cookie, sessions etc.
     *
     * @param  string $middleware
     */
/*    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        if (!$kernel->hasMiddleware()){
            $kernel->pushMiddleware($middleware);
        }
    }*/

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
/*    public function provides()
    {
        return [self::CONFIG_NAME];
    }*/

/*    private function basePath()
    {
        $pubPath = '';
        if (function_exists('config_path')) {
            $pubPath = config_path(self::CONFIG_NAME);
        } elseif (function_exists('base_path')) {
            $pubPath = base_path('config/' . self::CONFIG_NAME);
        }

        return $pubPath;
    }*/
}
