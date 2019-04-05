@extends('core::public.master')

@section('title', $model->title.' – '.__('News').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-news body-news-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'News', 'model' => $model])

    <article class="news" itemscope itemtype="http://schema.org/Article">
        <h1 class="news-title" itemprop="name">{{ $model->title }}</h1>
        <img src="{!! $model->present()->image(null, 200) !!}" alt="">
        <meta itemprop="image" content="{{ $model->present()->image() }}">
        <div class="news-date-wrapper" class="date">@lang('Published on')
            <time class="news-date" itemprop="datePublished" datetime="{{ $model->date->toIso8601String() }}">{{ $model->present()->dateLocalized }}</time>
        </div>
        <p class="news-summary" itemprop="headline">{{ nl2br($model->summary) }}</p>
        <div class="news-body" itemprop="articleBody">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
