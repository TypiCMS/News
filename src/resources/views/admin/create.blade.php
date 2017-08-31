@extends('core::admin.master')

@section('title', __('New news'))

@section('content')

    @include('core::admin._button-back', ['module' => 'news'])
    <h1>
        @lang('New news')
    </h1>

    {!! BootForm::open()->action(route('admin::index-news'))->multipart()->role('form') !!}
        @include('news::admin._form')
    {!! BootForm::close() !!}

@endsection
