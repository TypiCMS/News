<?php

namespace TypiCMS\Modules\News\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class NewsTranslation extends BaseTranslation
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\News\Models\News', 'news_id');
    }
}
