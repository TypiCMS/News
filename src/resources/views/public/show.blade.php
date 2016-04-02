@extends('core::public.master')

@section('title', $model->title.' – '.trans('news::global.name').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-news body-news-'.$model->id.' body-page body-page-'.$page->id)

@section('main')

    @include('core::public._btn-prev-next', ['module' => 'News', 'model' => $model])

    <article class="news" itemscope itemtype="http://schema.org/Article">
        <h1 class="news-title" itemprop="name">{{ $model->title }}</h1>
        {!! $model->present()->thumb(null, 200) !!}
        <meta itemprop="image" content="{{ $model->present()->thumbUrl() }}">
        <div class="news-date-wrapper" class="date">@lang('news::global.Published on')
            <time class="news-date" itemprop="datePublished" datetime="{{ $model->date->toIso8601String() }}">{{ $model->present()->dateLocalized }}</time>
        </div>
        <p class="news-summary" itemprop="headline">{{ nl2br($model->summary) }}</p>
        <div class="news-body" itemprop="articleBody">{!! $model->present()->body !!}</div>
    </article>

    @include('galleries::public._galleries')

@endsection
