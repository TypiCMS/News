<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Observers\TipTapHTMLObserver;
use TypiCMS\Modules\News\Composers\SidebarViewComposer;
use TypiCMS\Modules\News\Facades\News as NewsFacade;
use TypiCMS\Modules\News\Models\News;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/news.php', 'typicms.modules.news');

        $this->loadRoutesFrom(__DIR__ . '/../routes/news.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'news');

        $this->publishes([__DIR__ . '/../../database/migrations/create_news_table.php.stub' => getMigrationFileName('create_news_table')], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/news')], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        AliasLoader::getInstance()->alias('News', NewsFacade::class);

        // Observers
        News::observe(new SlugObserver());
        News::observe(new TipTapHTMLObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('news::public.*', function ($view) {
            $view->page = getPageLinkedToModule('news');
        });
    }

    public function register(): void
    {
        $this->app['config']->push('typicms.feeds', ['module' => 'news']);

        $this->app->bind('News', News::class);
    }
}
