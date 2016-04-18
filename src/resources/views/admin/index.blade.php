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

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('news::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">
        @include('core::admin._v-client-table')
        {{-- For server side filtering, just include core::admin._v-server-table --}}
    </div>

</div>

@endsection
