<?php

namespace Markohs\ForceHTTPS;

use Markohs\ForceHTTPS\Middleware\ForceHTTPS;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ForceHTTPSServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $router->middleware('forcehttps', 'Markohs\ForceHTTPS\Middleware\ForceHTTPS');

        if(config('forcehttps.autoregister')==null){
            // Avoid complex situations on config:cache and production apps
            return;
        }

        foreach (config('forcehttps.autoregister') as $group ){
            $router->pushMiddlewareToGroup($group,ForceHTTPS::class);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/forcehttps.php', 'forcehttps');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['forcehttps'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/forcehttps.php' => config_path('forcehttps.php'),
        ], 'forcehttps.config');
    }
}
