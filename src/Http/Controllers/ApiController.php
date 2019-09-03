<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\News\Models\News;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(News::class)
            ->allowedFilters([
                Filter::custom('title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(News $news, Request $request): JsonResponse
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
    }

    public function destroy(News $news): JsonResponse
    {
        $deleted = $news->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(News $news): Collection
    {
        return $news->files;
    }

    public function attachFiles(News $news, Request $request): JsonResponse
    {
        return $news->attachFiles($request);
    }

    public function detachFile(News $news, File $file): array
    {
        return $news->detachFile($file);
    }
}
