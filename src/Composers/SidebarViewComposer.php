<?php
namespace TypiCMS\Modules\News\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('news::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.news.sidebar.icon', 'icon fa fa-fw fa-bullhorn');
                $item->weight = config('typicms.news.sidebar.weight');
                $item->route('admin.news.index');
                $item->append('admin.news.create');
                $item->authorize(
                    $this->auth->hasAccess('news.index')
                );
            });
        });
    }
}
