<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Route;

class PluginsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Set routes
        $this->setupRoutes($this->app->router);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('plugins', function ($app) {
            return new Plugins($app);
        });

        // Load the plugins Services Provider & register them
		$pluginsDirs = glob(config('larapen.core.plugin.path') . '*', GLOB_ONLYDIR);
		if (!empty($pluginsDirs)) {
            foreach($pluginsDirs as $pluginDir) {
                $plugin = load_plugin(basename($pluginDir));
                if (!empty($plugin)) {
                    $this->app->register($plugin->provider);
                }
            }
        }
    }

    /**
     * Define the global routes for the plugins.
     *
     * @param Router $router
     */
    public function setupRoutes(Router $router)
    {
        // Public - Images
        Route::get('images/{plugin}/{filename}', function ($plugin, $filename)
        {
            $path = plugin_path($plugin, 'public/images/' . $filename);
            if (\File::exists($path)) {
                $file = \File::get($path);
                $type = \File::mimeType($path);

                $response = \Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            }

            abort(404);
        });

        // Public - Assets
        Route::get('assets/{plugin}/{type}/{file}', function ($plugin, $type, $file)
        {
            $path = plugin_path($plugin, 'public/assets/' . $type . '/' . $file);
            if (\File::exists($path)) {
                //return response()->download($path, "$file");
                if ($type == 'js') {
                    return response()->file($path, array('Content-Type' => 'application/javascript'));
                } else {
                    return response()->file($path, array('Content-Type' => 'text/css'));
                }
            }

            abort(404);
        });
    }
}
