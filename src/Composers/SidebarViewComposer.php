<?php

namespace TypiCMS\Modules\News\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use TypiCMS\Modules\Sidebar\SidebarGroup;
use TypiCMS\Modules\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view): void
    {
        if (Gate::denies('read news')) {
            return;
        }
        $view->offsetGet('sidebar')->group(__(config('typicms.modules.news.sidebar.group', 'Content')), function (SidebarGroup $group): void {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__(config('typicms.modules.news.sidebar.label', 'News')), function (SidebarItem $item): void {
                $item->id = 'news';
                $item->icon = config('typicms.modules.news.sidebar.icon');
                $item->weight = config('typicms.modules.news.sidebar.weight');
                $item->route('admin::index-news');
            });
        });
    }
}
