@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-news', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
    @include('news::admin._form')
    {!! BootForm::close() !!}
@endsection
