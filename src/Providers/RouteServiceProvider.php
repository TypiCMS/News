<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\News\Http\Controllers\AdminController;
use TypiCMS\Modules\News\Http\Controllers\ApiController;
use TypiCMS\Modules\News\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('news')) {
                $middleware = $page->private ? ['public', 'auth'] : ['public'];
                $router->middleware($middleware)->group(function (Router $router) use ($page) {
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, [PublicController::class, 'index'])->name($lang.'::index-news');
                            $router->get($uri.'.xml', [PublicController::class, 'feed'])->name($lang.'::news-feed');
                            $router->get($uri.'/{slug}', [PublicController::class, 'show'])->name($lang.'::news');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('news', [AdminController::class, 'index'])->name('admin::index-news')->middleware('can:read news');
                $router->get('news/create', [AdminController::class, 'create'])->name('admin::create-news')->middleware('can:create news');
                $router->get('news/{news}/edit', [AdminController::class, 'edit'])->name('admin::edit-news')->middleware('can:update news');
                $router->post('news', [AdminController::class, 'store'])->name('admin::store-news')->middleware('can:create news');
                $router->put('news/{news}', [AdminController::class, 'update'])->name('admin::update-news')->middleware('can:update news');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('news', [ApiController::class, 'index'])->middleware('can:read news');
                    $router->patch('news/{news}', [ApiController::class, 'updatePartial'])->middleware('can:update news');
                    $router->delete('news/{news}', [ApiController::class, 'destroy'])->middleware('can:delete news');

                    $router->get('news/{news}/files', [ApiController::class, 'files'])->middleware('can:update news');
                    $router->post('news/{news}/files', [ApiController::class, 'attachFiles'])->middleware('can:update news');
                    $router->delete('news/{news}/files/{file}', [ApiController::class, 'detachFile'])->middleware('can:update news');
                });
            });
        });
    }
}
