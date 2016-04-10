<?php

namespace TypiCMS\Modules\News\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use Spatie\Translatable\Translatable;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class News extends Base
{
    use Historable;
    use HasTranslations;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\News\Presenters\ModulePresenter';

    protected $dates = ['date'];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'status' => 'array',
        'summary' => 'array',
        'body' => 'array',
    ];

    protected $fillable = [
        'date',
        'image',
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];

    public function getTranslatableFields()
    {
        return [
            'title',
            'slug',
            'status',
            'summary',
            'body',
        ];
    }

    /**
     * A news has many galleries.
     *
     * @return MorphToMany
     */
    public function galleries()
    {
        return $this->morphToMany('TypiCMS\Modules\Galleries\Models\Gallery', 'galleryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }

    /**
     * Append status attribute from translation table.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->status;
    }

    /**
     * Append title attribute from translation table.
     *
     * @return string title
     */
    public function getTitleAttribute()
    {
        return $this->title;
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
