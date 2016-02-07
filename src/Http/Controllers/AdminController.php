<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Http\Requests\FormRequest;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class AdminController extends BaseAdminController
{
    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('core::admin.create')
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
        return view('core::admin.edit')
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
        $model = $this->repository->create($request->all());

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
        $this->repository->update($request->all());

        return $this->redirect($request, $news);
    }
}
