<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\News\Models\News;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(News::class)
            ->selectFields($request->input('fields.news'))
            ->allowedSorts(['status_translated', 'date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(News $news, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($news->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $news->setTranslation($key, $lang, $value);
                }
            } else {
                $news->{$key} = $content;
            }
        }

        $news->save();
    }

    public function destroy(News $news)
    {
        $news->delete();
    }
}
