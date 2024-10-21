@extends('pages::public.master')

@section('bodyClass', 'body-news body-news-index body-page body-page-' . $page->id)

@section('page')
    @include('news::public._itemlist-json-ld', ['items' => $models])
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])

            @includeWhen($models->count() > 0, 'news::public._list', ['items' => $models])
            {!! $models->appends(Request::except('page'))->links() !!}
        </div>
    </div>
@endsection
