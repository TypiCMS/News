<?php
namespace TypiCMS\Modules\News\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Models\NewsTranslation;
use TypiCMS\Modules\News\Repositories\CacheDecorator;
use TypiCMS\Modules\News\Repositories\EloquentNews;
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Modules\News\Services\Form\NewsFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addNamespace('news', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'news');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/news'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'News',
            'TypiCMS\Modules\News\Facades\Facade'
        );

        // Observers
        NewsTranslation::observe(new SlugObserver);
        News::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\News\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\News\Repositories\NewsInterface', function (Application $app) {
            $repository = new EloquentNews(new News);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['news', 'galleries'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\News\Services\Form\NewsForm', function (Application $app) {
            return new NewsForm(
                new NewsFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\News\Repositories\NewsInterface')
            );
        });

    }
}