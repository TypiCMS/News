@extends('core::admin.master')

@section('title', __('New news'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-news'))->multipart()->role('form') !!}
        @include('news::admin._form')
    {!! BootForm::close() !!}

@endsection
