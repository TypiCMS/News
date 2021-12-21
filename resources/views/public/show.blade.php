@extends('core::public.master')

@section('title', $model->title.' – '.__('News').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->image(1200, 630))
@section('bodyClass', 'body-news body-news-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

<article class="news">
    <header class="news-header">
        <div class="news-header-container">
            <div class="news-header-navigator">
                @include('core::public._items-navigator', ['module' => 'News', 'model' => $model])
            </div>
            <h1 class="news-title">{{ $model->title }}</h1>
            <div class="news-date">{{ $model->present()->dateLocalized }}</div>
        </div>
    </header>
    <div class="news-body">
        @include('news::public._json-ld', ['news' => $model])
        @empty(!$model->summary)
        <p class="news-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @include('core::public._share-links')
        @empty(!$model->image)
        <picture class="news-picture">
            <img class="news-picture-image" src="{{ $model->present()->image(2000, 1000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="">
            @empty(!$model->image->description)
            <legend class="news-picture-legend">{{ $model->image->description }}</legend>
            @endempty
        </picture>
        @endempty
        @empty(!$model->body)
        <div class="rich-content">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </div>
</article>

@endsection
