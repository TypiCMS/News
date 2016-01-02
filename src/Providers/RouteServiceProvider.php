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
                    if ($uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.news', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.news.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/news', ['as' => 'admin.news.index', 'uses' => 'AdminController@index']);
            $router->get('admin/news/create', ['as' => 'admin.news.create', 'uses' => 'AdminController@create']);
            $router->get('admin/news/{news}/edit', ['as' => 'admin.news.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/news', ['as' => 'admin.news.store', 'uses' => 'AdminController@store']);
            $router->put('admin/news/{news}', ['as' => 'admin.news.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/news', ['as' => 'api.news.index', 'uses' => 'ApiController@index']);
            $router->put('api/news/{news}', ['as' => 'api.news.update', 'uses' => 'ApiController@update']);
            $router->delete('api/news/{news}', ['as' => 'api.news.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
