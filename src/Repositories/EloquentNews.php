<?php

namespace TypiCMS\Modules\News\Repositories;

use TypiCMS\Modules\Core\EloquentRepository;
use TypiCMS\Modules\News\Models\News;

class EloquentNews extends EloquentRepository
{
    protected $repositoryId = 'news';

    protected $model = News::class;
}
