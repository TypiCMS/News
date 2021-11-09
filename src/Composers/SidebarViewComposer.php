<?php

namespace TypiCMS\Modules\News\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read news')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('News'), function (SidebarItem $item) {
                $item->id = 'news';
                $item->icon = config('typicms.news.sidebar.icon');
                $item->weight = config('typicms.news.sidebar.weight');
                $item->route('admin::index-news');
                $item->append('admin::create-news');
            });
        });
    }
}
