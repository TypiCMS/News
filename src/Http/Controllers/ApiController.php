<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Repositories\EloquentNews;

class ApiController extends BaseApiController
{
    public function __construct(EloquentNews $news)
    {
        parent::__construct($news);
    }

    public function index(Request $request)
    {
        $models = QueryBuilder::for(News::class)
            ->allowedFilters('date')
            ->translated(explode(',', $request->input('translatable_fields')))
            ->with('files')
            ->paginate($request->input('per_page'));

        return $models;
    }

    protected function update(News $news, Request $request)
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $news->$key = $value;
        }
        $saved = $news->save();

        $this->repository->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(News $news)
    {
        $deleted = $this->repository->delete($news);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
