@push('js')
<script>

</script>
@endpush

@extends('core::admin.master')

@section('title', __('News'))

@section('content')

<div>

    <item-list
        url-base="{{ route('api::index-news') }}"
        url-parameters="fields[news]=id,date,status,title"
        title="News"
        :sorting="['-date']">

        <template slot="add-button">
            @include('core::admin._button-create', ['module' => 'news'])
        </template>

        <template slot="buttons">
            @include('core::admin._lang-switcher-for-list')
        </template>

        <template slot="columns" slot-scope="{ sortArray }">
            <column-header name="edit"></column-header>
            <column-header name="status" translated sortable :sort-array="sortArray">Status</column-header>
            <column-header name="image">Image</column-header>
            <column-header name="date" sortable :sort-array="sortArray">Date</column-header>
            <column-header name="title" translated sortable :sort-array="sortArray">Title</column-header>
        </template>

        <template slot="table-row" slot-scope="{ model, checkedModels }">
            <td class="checkbox"><typi-checkbox :model="model" :checked-models-prop="checkedModels"></typi-checkbox></td>
            <td>@include('core::admin._button-edit', ['module' => 'news'])</td>
            <td><typi-btn-status :model="model"></typi-btn-status></td>
            <td><img :src="model.thumb" alt=""></td>
            <td>@{{ model.date | date }}</td>
            <td>@{{ model.title | translated }}</td>
        </template>

    </item-list>

</div>

@endsection
