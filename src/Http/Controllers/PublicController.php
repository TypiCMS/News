<?php
namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Str;
use Input;
use TypiCMS;
use TypiCMS\Controllers\BasePublicController;
use TypiCMS\Modules\News\Repositories\NewsInterface;
use View;

class PublicController extends BasePublicController
{

    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
        $this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

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
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        return view('news::public.show')
            ->with(compact('model'));
    }
}
