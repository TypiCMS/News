<?php

use TypiCMS\Modules\Core\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Http\Controllers\FeedController;
use TypiCMS\Modules\News\Http\Controllers\AdminController;
use TypiCMS\Modules\News\Http\Controllers\ApiController;
use TypiCMS\Modules\News\Http\Controllers\PublicController;

/*
 * Front office routes
 */
if (($page = getPageLinkedToModule('news')) instanceof Page) {
    $middleware = $page->private ? ['public', 'auth'] : ['public'];
    foreach (locales() as $lang) {
        if ($page->isPublished($lang) && $path = $page->path($lang)) {
            Route::middleware($middleware)->prefix($path)->name($lang . '::')->group(function (Router $router): void {
                $router->get('/', [PublicController::class, 'index'])->name('index-news');
                $router->get('{module}-feed.xml', FeedController::class)->name('news-feed');
                $router->get('{slug}', [PublicController::class, 'show'])->name('news');
            });
        }
    }
}

/*
 * Admin routes
 */
Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router): void {
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
Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router): void {
    $router->get('news', [ApiController::class, 'index'])->middleware('can:read news');
    $router->patch('news/{news}', [ApiController::class, 'updatePartial'])->middleware('can:update news');
    $router->post('news/{news}/duplicate', [ApiController::class, 'duplicate'])->middleware('can:create news');
    $router->delete('news/{news}', [ApiController::class, 'destroy'])->middleware('can:delete news');
});
