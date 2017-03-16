<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\News\Composers\SidebarViewComposer;
use TypiCMS\Modules\News\Facades\News as NewsFacade;
use TypiCMS\Modules\News\Models\News;
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

        AliasLoader::getInstance()->alias('News', NewsFacade::class);

        // Observers
        News::observe(new SlugObserver());
    }

    public function register()
    {
        $app = $this->app;

        $this->app['config']->push('typicms.feeds', ['module' => 'news']);

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $app->view->composer('news::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('news');
        });

        $app->bind('News', EloquentNews::class);
    }
}
