<li class="news-list-item">
    <a class="news-list-item-link" href="{{ $news->uri() }}">
        @empty (!$news->image)
        <img class="news-list-item-image" src="{{ $news->present()->image(540, 400) }}" width="{{ $news->image->width }}" height="{{ $news->image->height }}" alt="{{ $news->image->alt_attribute }}">
        @endempty
        <div class="news-list-item-info">
            <h2 class="news-list-item-title">{{ $news->title }}</h2>
            <div class="news-list-item-date">{{ $news->present()->dateLocalized }}</div>
            @empty(!$news->summary)
            <div class="news-list-item-summary">{{ $news->summary }}</div>
            @endempty
        </div>
    </a>
</li>
