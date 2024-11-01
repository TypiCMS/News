<li class="news-list-item">
    <a class="news-list-item-link" href="{{ $news->uri() }}">
        <img class="news-list-item-image" src="{{ $news->present()->image(800, 600) }}" width="400" height="300" alt="{{ $news->image?->alt_attribute }}" />
        <div class="news-list-item-info">
            <h2 class="news-list-item-title">{{ $news->title }}</h2>
            <div class="news-list-item-date">{{ $news->present()->dateLocalized }}</div>
            @if(!empty($news->summary))
                <div class="news-list-item-summary">{{ $news->summary }}</div>
            @endif
        </div>
    </a>
</li>
