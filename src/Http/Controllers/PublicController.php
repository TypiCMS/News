<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Input;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class PublicController extends BasePublicController
{
    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        $page = Input::get('page');
        $perPage = config('typicms.news.per_page');
        $data = $this->repository->byPage($page, $perPage, ['translations']);
        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('news::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('news::public.show')
            ->with(compact('model'));
    }
}
