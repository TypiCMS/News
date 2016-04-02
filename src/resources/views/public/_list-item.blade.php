<li class="news" itemscope itemtype="http://schema.org/Article">
    <a class="news-anchor" href="{{ route($lang.'.news.slug', $news->slug) }}" itemprop="url">
        {!! $news->present()->thumb(540, 400) !!}
        <meta itemprop="image" content="{{ $news->present()->thumbUrl() }}">
        <div class="news-info">
            <h2 class="news-title" itemprop="name">{{ $news->title }}</h2>
            <div class="news-date-wrapper">@lang('news::global.Published on')
                <time class="news-date" itemprop="datePublished" datetime="{{ $news->date->toIso8601String() }}">{{ $news->present()->dateLocalized }}</time>
            </div>
            <div class="news-summary" itemprop="headline">{{ $news->summary }}</div>
        </div>
    </a>
</li>
