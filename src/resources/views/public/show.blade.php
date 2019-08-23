@extends('core::public.master')

@section('title', $model->title.' – '.__('News').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-news body-news-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'News', 'model' => $model])

    @include('news::public._json-ld', ['news' => $model])

    <article class="news">
        <h1 class="news-title">{{ $model->title }}</h1>
        <img class="news-image" src="{!! $model->present()->image(null, 200) !!}" alt="">
        <div class="news-date">{{ $model->present()->dateLocalized }}</div>
        <p class="news-summary">{!! nl2br($model->summary) !!}</p>
        <div class="news-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
