<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\News\Models\News;

class ApiController extends BaseApiController
{
    /** @return LengthAwarePaginator<int, mixed> */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = News::query()->selectFields();
        $data = QueryBuilder::for($query)
            ->allowedSorts(['status_translated', 'date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->integer('per_page'));

        return $data;
    }

    protected function updatePartial(News $news, Request $request): void
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

    public function duplicate(News $news)
    {
        $newNews = $news->replicate();
        $newNews->setTranslations('status', []);
        $newNews->save();
    }

    public function destroy(News $news): JsonResponse
    {
        $news->delete();

        return response()->json(status: 204);
    }
}
