@extends('pages::public.master')

@section('bodyClass', 'body-news body-news-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('news::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Request::except('page'))->links() !!}

@endsection
