<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Http\Requests\FormRequest;
use TypiCMS\Modules\News\Models\News;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('news::admin.index');
    }

    public function create(): View
    {
        $model = new News();

        return view('news::admin.create')
            ->with(compact('model'));
    }

    public function edit(News $news): View
    {
        return view('news::admin.edit')
            ->with(['model' => $news]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $data = $request->except('file_ids');
        $model = News::create($data);

        return $this->redirect($request, $model);
    }

    public function update(News $news, FormRequest $request): RedirectResponse
    {
        $data = $request->except('file_ids');
        $news->update($data);

        return $this->redirect($request, $news);
    }
}
