<li class="news-list-item" itemscope itemtype="http://schema.org/Article">
    <a class="news-list-item-link" href="{{ $news->uri() }}" itemprop="url">
        {!! $news->present()->thumb(540, 400) !!}
        <meta itemprop="image" content="{{ $news->present()->thumbUrl() }}">
        <div class="news-list-item-info">
            <h2 class="news-list-item-title" itemprop="name">{{ $news->title }}</h2>
            <div class="news-list-item-date-wrapper">@lang('Published on')
                <time class="news-list-item-date" itemprop="datePublished" datetime="{{ $news->date->toIso8601String() }}">{{ $news->present()->dateLocalized }}</time>
            </div>
            <div class="news-list-item-summary" itemprop="headline">{{ $news->summary }}</div>
        </div>
    </a>
</li>
