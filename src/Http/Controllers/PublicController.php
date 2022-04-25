<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Models\News;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = News::published()
            ->order()
            ->with('image')
            ->paginate(config('typicms.news.per_page'));

        return view('news::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = News::published()
            ->with([
                'image',
                'images',
                'documents',
            ])
            ->whereSlugIs($slug)
            ->firstOrFail();

        return view('news::public.show')
            ->with(compact('model'));
    }
}
