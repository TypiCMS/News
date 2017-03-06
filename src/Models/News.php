<?php

namespace TypiCMS\Modules\News\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Galleries\Models\Gallery;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\News\Presenters\ModulePresenter;

class News extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['date'];

    protected $guarded = ['id', 'exit', 'galleries'];

    protected $appends = ['thumb', 'title_translated'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    public $attachments = [
        'image',
    ];

    /**
     * A news has many galleries.
     *
     * @return MorphToMany
     */
    public function galleries()
    {
        return $this->morphToMany(Gallery::class, 'galleryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getTitleTranslatedAttribute()
    {
        $locale = config('app.locale');

        return $this->translate('title', config('typicms.content_locale', $locale));
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
