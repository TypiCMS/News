<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Facades\TypiCMS;
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

    public function feed()
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

            $feed->title = TypiCMS::title();
            $feed->subtitle = $page->title;
            $feed->description = $page->body;
            if (config('typicms.image')) {
                $feed->logo = Storage::url('settings/'.config('typicms.image'));
            }
            $feed->link = url()->route(config('app.locale').'::news-feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            if (isset($models[0]) && !empty($models[0]->date)) {
                $feed->pubdate = $models[0]->date;
            }
            $feed->lang = config('app.locale');
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($models as $model) {
                $feed->addItem([
                    'title' => $model->title,
                    'author' => config('app.name'),
                    'url' => url($model->uri()),
                    'link' => url($model->uri()),
                    'pubdate' => $model->date->format(DATE_RFC3339),
                    'description' => $model->summary,
                    'content' => $model->present()->body,
                ]);
            }
        }

        return $feed->render('atom');
    }
}
