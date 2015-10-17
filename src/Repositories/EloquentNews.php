<?php

namespace TypiCMS\Modules\News\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentNews extends RepositoriesAbstract implements NewsInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
