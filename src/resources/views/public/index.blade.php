@extends('pages::public.master')
<?php $page = TypiCMS::getPageLinkedToModule('news') ?>

@section('bodyClass', 'body-news body-news-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('news::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
