<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\News\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('news')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.news', 'uses' => 'PublicController@index']);
                        $router->get($uri.'.xml', $options + ['as' => $lang.'.news.feed', 'uses' => 'PublicController@feed']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.news.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/news', 'AdminController@index')->name('admin::index-news');
            $router->get('admin/news/create', 'AdminController@create')->name('admin::create-news');
            $router->get('admin/news/{news}/edit', 'AdminController@edit')->name('admin::edit-news');
            $router->post('admin/news', 'AdminController@store')->name('admin::store-news');
            $router->put('admin/news/{news}', 'AdminController@update')->name('admin::update-news');

            /*
             * API routes
             */
            $router->get('api/news', 'ApiController@index')->name('api::index-news');
            $router->put('api/news/{news}', 'ApiController@update')->name('api::update-news');
            $router->delete('api/news/{news}', 'ApiController@destroy')->name('api::destroy-news');
        });
    }
}
