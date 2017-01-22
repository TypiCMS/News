@extends('core::admin.master')

@section('title', __('news::global.New'))

@section('content')

    @include('core::admin._button-back', ['module' => 'news'])
    <h1>
        @lang('news::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-news'))->multipart()->role('form') !!}
        @include('news::admin._form')
    {!! BootForm::close() !!}

@endsection
