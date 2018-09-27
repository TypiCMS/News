@extends('pages::public.master')

@section('bodyClass', 'body-news body-news-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

        @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])


    @includeWhen($models->count() > 0, 'news::public._list', ['items' => $models])

    {!! $models->appends(Request::except('page'))->links() !!}

@endsection
