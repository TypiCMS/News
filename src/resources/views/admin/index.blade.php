@extends('core::admin.master')

@section('title', trans('news::global.name'))

@section('js')

<script>
    new Vue({
        el: "#news",
        methods: {
            deleteMe: function (id) {
                alert("Delete " + id);
            }
        },
        data: {
            tableData: TypiCMS.models,
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
                    status: '<div class="btn btn-xs btn-link" @click="action()">' +
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
</script>

@endsection

@section('main')

<div id="news">

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('news::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

<!--     <div class="table-responsive">
      <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
    </div>
 -->
    <div class="table-responsive">
      <v-server-table url="{{ route('api::index-news') }}" :columns="columns" :options="options"></v-server-table>
    </div>

</div>

@endsection
