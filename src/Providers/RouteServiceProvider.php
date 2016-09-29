<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
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
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('news')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable-bootforms.locales') as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.news', 'uses' => 'PublicController@index']);
                        $router->get($uri.'.xml', $options + ['as' => $lang.'.news.feed', 'uses' => 'PublicController@feed']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.news.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function(Router $router) {
                $router->get('news', 'AdminController@index')->name('admin::index-news');
                $router->get('news/create', 'AdminController@create')->name('admin::create-news');
                $router->get('news/{news}/edit', 'AdminController@edit')->name('admin::edit-news');
                $router->post('news', 'AdminController@store')->name('admin::store-news');
                $router->put('news/{news}', 'AdminController@update')->name('admin::update-news');
            });

            /*
             * API routes
             */
            $router->group(['middleware' => 'api', 'prefix' => 'api'], function(Router $router) {
                $router->get('news', 'ApiController@index')->name('api::index-news');
                $router->put('news/{news}', 'ApiController@update')->name('api::update-news');
                $router->delete('news/{news}', 'ApiController@destroy')->name('api::destroy-news');
            });
        });
    }
}
