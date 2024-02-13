<?php

namespace TypiCMS\Modules\News\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\News\Presenters\ModulePresenter;

#[ObservedBy(SlugObserver::class)]
class News extends Base implements Feedable
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $guarded = [];

    protected $appends = ['thumb'];

    public array $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary ?? '')
            ->updated($this->updated_at)
            ->link($this->uri())
            ->authorName($this->author ?? config('app.name'));
    }

    protected function thumb(): Attribute
    {
        return new Attribute(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
