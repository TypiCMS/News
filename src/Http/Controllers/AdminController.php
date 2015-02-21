<?php
namespace TypiCMS\Modules\News\Http\Controllers;

use TypiCMS\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Http\Requests\FormRequest;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class AdminController extends BaseAdminController
{

    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}
