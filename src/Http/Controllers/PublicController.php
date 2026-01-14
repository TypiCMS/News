<?php

declare(strict_types=1);

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Models\News;

final class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = News::query()
            ->published()
            ->order()
            ->with('image')
            ->paginate(config('typicms.modules.news.per_page'));

        return view('news::public.index', ['models' => $models]);
    }

    public function show(string $slug): View
    {
        $model = News::query()
            ->published()
            ->with([
                'image',
                'images',
                'documents',
            ])
            ->whereSlugIs($slug)
            ->firstOrFail();

        return view('news::public.show', ['model' => $model]);
    }
}
