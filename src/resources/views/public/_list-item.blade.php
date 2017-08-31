<li class="newslist-item" itemscope itemtype="http://schema.org/Article">
    <a class="newslist-item-link" href="{{ route($lang.'::news', $news->slug) }}" itemprop="url">
        {!! $news->present()->thumb(540, 400) !!}
        <meta itemprop="image" content="{{ $news->present()->thumbUrl() }}">
        <div class="newslist-item-info">
            <h2 class="newslist-item-title" itemprop="name">{{ $news->title }}</h2>
            <div class="newslist-item-date-wrapper">@lang('Published on')
                <time class="newslist-item-date" itemprop="datePublished" datetime="{{ $news->date->toIso8601String() }}">{{ $news->present()->dateLocalized }}</time>
            </div>
            <div class="newslist-item-summary" itemprop="headline">{{ $news->summary }}</div>
        </div>
    </a>
</li>
