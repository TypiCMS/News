<li class="news-list-item">
    <a class="news-list-item-link" href="{{ $news->uri() }}">
        <img class="news-list-item-image" src="{!! $news->present()->image(540, 400) !!}" alt="">
        <div class="news-list-item-info">
            <h2 class="news-list-item-title">{{ $news->title }}</h2>
            <div class="news-list-item-date">{{ $news->present()->dateLocalized }}</div>
            <div class="news-list-item-summary">{{ $news->summary }}</div>
        </div>
    </a>
</li>
