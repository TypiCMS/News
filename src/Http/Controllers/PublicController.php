<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Roumen\Feed\Feed;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Repositories\EloquentNews;

class PublicController extends BasePublicController
{
    private $feed;

    public function __construct(EloquentNews $news, Feed $feed)
    {
        $this->feed = $feed;
        parent::__construct($news);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = Request::input('page');
        $perPage = config('typicms.news.per_page');
        $models = $this->repository->published()->paginate($perPage, ['title', 'slug', 'image', 'summary', 'date'], 'page', $page);

        return view('news::public.index')
            ->with(compact('models'));
    }

    /**
     * Generate Atom feed.
     */
    public function feed()
    {
        $page = TypiCMS::getPageLinkedToModule('news');
        if (!$page) {
            return;
        }
        $feed = $this->feed;
        if (config('typicms.cache')) {
            $feed->setCache(60, 'typicmsNewsFeed');
        }
        if (!$feed->isCached()) {
            $models = $this->repository->latest(10);

            $feed->title = $page->title.' – '.TypiCMS::title();
            $feed->description = $page->body;
            if (config('typicms.image')) {
                $feed->logo = url('uploads/settings/'.config('typicms.image'));
            }
            $feed->link = url()->route(config('app.locale').'::news.feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            if (isset($models[0]) && $models[0]->date) {
                $feed->pubdate = $models[0]->date;
            }
            $feed->lang = config('app.locale');
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($models as $model) {
                $feed->add($model->title, null, url($model->uri()), $model->date, $model->summary, $model->body);
            }
        }

        return $feed->render('atom');
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->with(['galleries'])->bySlug($slug);

        return view('news::public.show')
            ->with(compact('model'));
    }
}
