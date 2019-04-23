<?php namespace Watson\Sitemap;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sitemap', 'Watson\Sitemap\Sitemap');

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'sitemap'
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'sitemap');
        
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('sitemap.php'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/sitemap'),
        ], 'views');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sitemap'];
    }
}
