<?php
namespace TypiCMS\Modules\News\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('news', [
            'weight' => config('typicms.news.sidebar.weight'),
            'request' => $view->prefix . '/news*',
            'route' => 'admin.news.index',
            'icon-class' => 'icon fa fa-fw fa-bullhorn',
            'title' => 'News',
        ]);
    }
}
