<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace Larapen\LaravelLocalization;

use Illuminate\Support\ServiceProvider;

class LaravelLocalizationServiceProvider extends ServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$packageConfigFile = __DIR__ . '/../../config/config.php';
		
		$this->mergeConfigFrom($packageConfigFile, 'laravellocalization');
		
		$this->registerBindings();
		
		$this->registerCommands();
	}
	
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('laravellocalization.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules.handler', 'modules'];
    }
	
	/**
	 * Registers app bindings and aliases.
	 */
	protected function registerBindings()
	{
		$this->app->singleton(LaravelLocalization::class, function () {
			return new LaravelLocalization();
		});
		
		$this->app->alias(LaravelLocalization::class, 'laravellocalization');
	}
	
	/**
	 * Registers route caching commands.
	 */
	protected function registerCommands()
	{
		$this->app->singleton('laravellocalizationroutecache.cache', Commands\RouteTranslationsCacheCommand::class);
		$this->app->singleton('laravellocalizationroutecache.clear', Commands\RouteTranslationsClearCommand::class);
		$this->app->singleton('laravellocalizationroutecache.list', Commands\RouteTranslationsListCommand::class);
		
		$this->commands([
			'laravellocalizationroutecache.cache',
			'laravellocalizationroutecache.clear',
			'laravellocalizationroutecache.list',
		]);
	}
}
