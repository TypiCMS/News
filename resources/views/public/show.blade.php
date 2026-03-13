@extends('core::public.master')

@section('title', $model->title . ' – ' . __('News') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->ogImageUrl())
@section('bodyClass', 'body-news body-news-' . $model->id . ' body-page body-page-' . $page->id)

@section('content')
    <article class="news">
        <header class="news-header">
            <div class="news-header-container">
                <div class="news-header-navigator">
                    <x-core::items-navigator :$model :$page />
                </div>
                <h1 class="news-title">{{ $model->title }}</h1>
                <div class="news-date">{{ $model->dateLocalized() }}</div>
            </div>
        </header>
        <div class="news-body">
            <x-core::json-ld :schema="[
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $model->url(),
                ],
                'headline' => $model->title,
                'image' => [$model->imageUrl()],
                'datePublished' => $model->date->toIso8601String(),
                'dateModified' => $model->updated_at->toIso8601String(),
                'author' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => Vite::asset(config('typicms.logo')),
                    ],
                ],
                'description' => preg_replace('/\r|\n/', ' ', $model->summary),
            ]" />
            @if ($model->summary)
                <p class="news-summary">{!! nl2br($model->summary) !!}</p>
            @endif

            <x-core::share-links :$model />
            @if ($model->image)
                <figure class="news-picture">
                    <img class="news-picture-image" src="{{ $model->imageUrl(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @if ($model->image->description)
                        <figcaption class="news-picture-legend">{{ $model->image->description }}</figcaption>
                    @endif
                </figure>
            @endif

            @if ($model->body)
                <div class="rich-content">{!! $model->formattedBody() !!}</div>
            @endif

            @include('files::public._document-list')
            @include('files::public._image-list')
        </div>
    </article>
@endsection
