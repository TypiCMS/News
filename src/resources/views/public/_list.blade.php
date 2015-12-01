<ul class="news-list">
    @foreach ($items as $news)
    @include('news::public._list-item')
    @endforeach
</ul>
