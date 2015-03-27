@extends('core::public.master')

@section('title', trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('news::global.name'))
@section('bodyClass', 'body-news-index')

@section('main')

    <h1>@lang('news::global.name')</h1>

    @if ($models->count())
    @include('news::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
