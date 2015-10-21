<?php

namespace App\Providers;
use App\Module;
use Html, Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Html::macro('isActive', function($url) {
            return Request::is($url) || Request::is($url.'/*') ? 'active' : '';
        });
        Html::macro('isAContentModuleActive', function() {
            $url = Request::segment(1);
            $contentModules = Module::where('enabled', '=', true)
                                        ->where('is_content_module', '=', true)
                                        ->lists('name')
                                        ->all();
            return in_array($url, $contentModules) ? 'active' : '';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
