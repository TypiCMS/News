@extends('core::admin.master')

@section('title', trans('news::global.name'))

@section('main')

<div id="table">

    <script>
    var columns = ['id', 'status', 'thumb', 'date', 'title'];
    var options = {
        sortable: ['status', 'date', 'title'],
        headings: {},
        orderBy: {
            column: 'date',
            ascending: false
        }
    };
    </script>

    @include('core::admin._table-config')

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('news::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">
        @include('core::admin._v-server-table', ['url' => route('admin::index-news')])
        {{-- For client side filtering: --}}
        {{-- @include('core::admin._v-client-table', ['data' => News::allFiltered(config('typicms.news.select'))]) --}}
    </div>

</div>

@endsection
