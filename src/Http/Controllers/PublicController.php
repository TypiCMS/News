<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Models\News;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = News::published()->with('image')
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

    public function feed(): ?Response
    {
        $page = TypiCMS::getPageLinkedToModule('news');
        if (!$page) {
            return null;
        }
        $feed = app('feed');
        if (config('typicms.cache')) {
            $feed->setCache(60, 'typicmsNewsFeed');
        }
        if (!$feed->isCached()) {
            $models = News::published()
                ->order()
                ->take(10)
                ->get();

            $feed->title = $page->title.' – '.TypiCMS::title();
            $feed->description = $page->body;
            if (config('typicms.image')) {
                $feed->logo = Storage::url('settings/'.config('typicms.image'));
            }
            $feed->link = url()->route(config('app.locale').'::news-feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            if (isset($models[0]) && $models[0]->date) {
                $feed->pubdate = $models[0]->date;
            }
            $feed->lang = config('app.locale');
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($models as $model) {
                $feed->add($model->title, null, url($model->uri()), $model->date, $model->summary, $model->present()->body);
            }
        }

        return $feed->render('atom');
    }
}
