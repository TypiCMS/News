<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\News\Composers\SidebarViewComposer;
use TypiCMS\Modules\News\Facades\News as NewsFacade;
use TypiCMS\Modules\News\Models\News;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.news');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        config(['typicms.modules.news' => ['linkable_to_page', 'has_feed']]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'news');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_news_table.php.stub' => getMigrationFileName('create_news_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/news'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/scss' => resource_path('scss'),
        ], 'resources');

        AliasLoader::getInstance()->alias('News', NewsFacade::class);

        // Observers
        News::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('news::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('news');
        });
    }

    public function register(): void
    {
        $this->app['config']->push('typicms.feeds', ['module' => 'news']);

        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('News', News::class);
    }
}
