<?php

declare(strict_types=1);

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\News\Composers\SidebarViewComposer;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/news.php', 'typicms.modules.news');

        $this->loadRoutesFrom(__DIR__ . '/../routes/news.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'news');

        $this->publishes([
            __DIR__ . '/../../database/migrations/create_news_table.php.stub' => getMigrationFileName(
                'create_news_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/news')], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('news::public.*', function ($view): void {
            $view->page = getPageLinkedToModule('news');
        });
    }
}
