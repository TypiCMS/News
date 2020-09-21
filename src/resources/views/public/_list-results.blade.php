<ul class="news-list-results-list">
    @foreach ($items as $news)
    <li class="news-list-results-item">
        <a class="news-list-results-item-link" href="{{ $news->uri() }}">
            {{ $news->title }}
        </a>
    </li>
    @endforeach
</ul>
