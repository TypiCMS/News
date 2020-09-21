<?php

namespace TypiCMS\Modules\News\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\News\Models\News;

class NewsExport implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(News::class)
            ->allowedSorts(['status_translated', 'date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->status,
            Date::dateTimeToExcel($model->date),
            $model->title,
            $model->summary,
            $model->body,
        ];
    }

    public function headings(): array
    {
        return [
            'created_at',
            'updated_at',
            'published',
            'date',
            'title',
            'summary',
            'body',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'D' => NumberFormat::FORMAT_DATE_DMYSLASH,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
