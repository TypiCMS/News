@extends('core::admin.master')

@section('title', __('New news'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-news'))->addClass('main-content') !!}
    @include('news::admin._form')
    {!! BootForm::close() !!}
@endsection
