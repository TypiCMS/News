<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Models\NewsTranslation;
use TypiCMS\Modules\News\Repositories\CacheDecorator;
use TypiCMS\Modules\News\Repositories\EloquentNews;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.news'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['news' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'news');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'news');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/news'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'News',
            'TypiCMS\Modules\News\Facades\Facade'
        );

        // Observers
        NewsTranslation::observe(new SlugObserver());
        News::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        $this->app['config']->push('typicms.feeds', ['module' => 'news']);

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\News\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\News\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('news::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('news');
        });

        $app->bind('TypiCMS\Modules\News\Repositories\NewsInterface', function (Application $app) {
            $repository = new EloquentNews(new News());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['news', 'galleries'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
