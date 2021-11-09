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
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('news')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-news');
                        $router->get('feed.xml', [PublicController::class, 'feed'])->name('news-feed');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('news');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('news', [AdminController::class, 'index'])->name('index-news')->middleware('can:read news');
            $router->get('news/export', [AdminController::class, 'export'])->name('export-news')->middleware('can:read news');
            $router->get('news/create', [AdminController::class, 'create'])->name('create-news')->middleware('can:create news');
            $router->get('news/{news}/edit', [AdminController::class, 'edit'])->name('edit-news')->middleware('can:read news');
            $router->post('news', [AdminController::class, 'store'])->name('store-news')->middleware('can:create news');
            $router->put('news/{news}', [AdminController::class, 'update'])->name('update-news')->middleware('can:update news');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('news', [ApiController::class, 'index'])->middleware('can:read news');
            $router->patch('news/{news}', [ApiController::class, 'updatePartial'])->middleware('can:update news');
            $router->delete('news/{news}', [ApiController::class, 'destroy'])->middleware('can:delete news');

            $router->get('news/{news}/files', [ApiController::class, 'files'])->middleware('can:update news');
            $router->post('news/{news}/files', [ApiController::class, 'attachFiles'])->middleware('can:update news');
            $router->delete('news/{news}/files/{file}', [ApiController::class, 'detachFile'])->middleware('can:update news');
        });
    }
}
