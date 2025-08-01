@extends('core::admin.master')

@section('title', __('News'))

@section('content')
    <item-list url-base="/api/news" fields="id,image_id,date,status,title" table="news" title="news" include="image" :exportable="true" :duplicable="false" :searchable="['title']" :sorting="['-date']">
        <template #add-button v-if="$can('create news')">
            @include('core::admin._button-create', ['module' => 'news'])
        </template>

        <template #columns="{ sortArray }">
            <item-list-column-header name="checkbox" v-if="$can('update news')||$can('delete news')"></item-list-column-header>
            <item-list-column-header name="edit" v-if="$can('update news')"></item-list-column-header>
            <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
            <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
            <item-list-column-header name="date" sortable :sort-array="sortArray" :label="$t('Date')"></item-list-column-header>
            <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        </template>

        <template #table-row="{ model, checkedModels, loading, toggleStatus }">
            <td class="checkbox" v-if="$can('update news')||$can('delete news')">
                <item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox>
            </td>
            <td v-if="$can('update news')">
                <item-list-edit-button :url="'/admin/news/' + model.id + '/edit'"></item-list-edit-button>
            </td>
            <td>
                <item-list-status-button :model="model"></item-list-status-button>
            </td>
            <td><img :src="model.thumb" alt="" height="27" /></td>
            <td>@{{ formatDate(model.date) }}</td>
            <td v-html="model.title_translated"></td>
        </template>
    </item-list>
@endsection
