<?php

namespace TypiCMS\Modules\News\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('news::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.news.sidebar.icon', 'icon fa fa-fw fa-bullhorn');
                $item->weight = config('typicms.news.sidebar.weight');
                $item->route('admin::index-news');
                $item->append('admin::create-news');
                $item->authorize(
                    Gate::allows('index-news')
                );
            });
        });
    }
}
