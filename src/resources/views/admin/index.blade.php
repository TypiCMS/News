@extends('core::admin.master')

@section('title', trans('news::global.name'))

@section('js')

<script>
    var table = new Vue({
        el: "#news",
        methods: {
            deleteMe: function (id) {
                alert("Delete " + id);
            }
        },
        data: {
            loading: false,
            tableData: {!! $models !!},
            columns: ['id', 'status', 'thumb', 'date', 'title'],
            options: {
                sortable: ['status', 'date', 'title'],
                dateFormat: 'yyyy mm dd',
                perPage: 25,
                perPageValues: [25, 50, 100, 500, 1000, 5000],
                headings: {
                    id: '',
                    status: 'Status',
                    thumb: 'Image',
                    date: 'Date',
                    title: 'Title'
                },
                templates: {
                    id: '<a href="javascript:void(0);" @click="$parent.deleteMe({id})"><span class="fa fa-remove"></span></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="news/{id}/edit">Edit</i></a>',
                    status: '<div @click="action()">' +
                        '<span class="fa switch" :class="{status} ? \'fa-toggle-on\' : \'fa-toggle-off\'"></span>' +
                    '</div>',
                    thumb: '<img src="{thumb}">'
                },
                orderBy: {
                    column: 'date',
                    ascending: false
                }
            }
        }
    });

    var timeout;
    table.$on('vue-tables.loaded', function() {
        window.clearTimeout(timeout);
        this.loading = false;
    });

    table.$on('vue-tables.loading', function() {
        var $this = this;
        timeout = window.setTimeout(function(){
            $this.loading = true;
        }, 1000);
    });

</script>

@endsection

@section('main')

<div id="news">

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('news::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    @if ($models->count())
    <div class="table-responsive">
        <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
    </div>
    @else
    <div class="table-responsive">
        <div class="VueTables__loading" v-if="loading">
            <span class="VueTables__spinner fa fa-spin fa-fw fa-gear fa-3x"></span>
        </div>
        <v-server-table url="{{ route('api::index-news') }}" :columns="columns" :options="options"></v-server-table>
    </div>
    @endif

</div>

@endsection
