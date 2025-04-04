@extends('core::public.master')

@section('title', $model->title . ' – ' . __('News') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->ogImage())
@section('bodyClass', 'body-news body-news-' . $model->id . ' body-page body-page-' . $page->id)

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
            @if(!empty($model->summary))
                <p class="news-summary">{!! nl2br($model->summary) !!}</p>
            @endif

            @include('core::public._share-links')
            @if(!empty($model->image))
                <figure class="news-picture">
                    <img class="news-picture-image" src="{{ $model->present()->image(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @if(!empty($model->image->description))
                        <figcaption class="news-picture-legend">{{ $model->image->description }}</figcaption>
                    @endif
                </figure>
            @endif

            @if(!empty($model->body))
                <div class="rich-content">{!! $model->present()->body !!}</div>
            @endif

            @include('files::public._document-list')
            @include('files::public._image-list')
        </div>
    </article>
@endsection
