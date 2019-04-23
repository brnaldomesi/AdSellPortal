<?php 

namespace ChrisKonnertz\OpenGraph;

use ChrisKonnertz\OpenGraph\OpenGraph;
use Illuminate\Support\ServiceProvider;

class OpenGraphServiceProvider extends ServiceProvider 
{

    public function register()
    {
        $this->app->bind('opengraph', function()
        {
            return new OpenGraph;
        });
    }

}
