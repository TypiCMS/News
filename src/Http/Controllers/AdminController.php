<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Exports\Export;
use TypiCMS\Modules\News\Http\Requests\FormRequest;
use TypiCMS\Modules\News\Models\News;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('news::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' news.xlsx';

        return Excel::download(new Export(), $filename);
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
        $news = News::create($request->validated());

        return $this->redirect($request, $news);
    }

    public function update(News $news, FormRequest $request): RedirectResponse
    {
        $news->update($request->validated());

        return $this->redirect($request, $news);
    }
}
