@extends('pages::public.master')

@section('bodyClass', 'body-news body-news-index body-page body-page-'.$page->id)

@section('page')

<div class="page-body">

    <div class="page-body-container">

        <div class="rich-content">{!! $page->present()->body !!}</div>

        @include('files::public._documents', ['model' => $page])
        @include('files::public._images', ['model' => $page])

        @include('news::public._itemlist-json-ld', ['items' => $models])

        @includeWhen($models->count() > 0, 'news::public._list', ['items' => $models])

        {!! $models->appends(Request::except('page'))->links() !!}

    </div>

</div>

@endsection
