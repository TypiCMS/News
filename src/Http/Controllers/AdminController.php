<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Http\Requests\FormRequest;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Repositories\EloquentNews;

class AdminController extends BaseAdminController
{
    public function __construct(EloquentNews $news)
    {
        parent::__construct($news);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->with('files')->findAll();
        app('JavaScript')->put('models', $models);

        return view('news::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();
        app('JavaScript')->put('model', $model);

        return view('news::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\News\Models\News $news
     *
     * @return \Illuminate\View\View
     */
    public function edit(News $news)
    {
        app('JavaScript')->put('model', $news);

        return view('news::admin.edit')
            ->with(['model' => $news]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\News\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $data = $request->all();
        $model = $this->repository->create($data);

        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\News\Models\News               $news
     * @param \TypiCMS\Modules\News\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(News $news, FormRequest $request)
    {
        $data = $request->all();
        $this->repository->update($news->id, $data);

        return $this->redirect($request, $news);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\News\Models\News $news
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(News $news)
    {
        $deleted = $this->repository->delete($news);

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function files(News $news)
    {
        $data = [
            'models' => $news->files,
        ];

        return response()->json($data, 200);
    }
}
