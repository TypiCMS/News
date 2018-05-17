@push('js')
<script>

</script>
@endpush

@extends('core::admin.master')

@section('title', __('News'))

@section('content')

<div>

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('News')</h1>

    <item-list url="{{ route('admin::index-news') }}">

        <template slot="buttons">
            @include('core::admin._button-actions')
            @include('core::admin._lang-switcher-for-list')
        </template>

        <template slot="columns">
            <th class="delete"></th>
            <th class="edit"></th>
            <th class="status">{{ __('Status') }}</th>
            <th class="image">{{ __('Image') }}</th>
            <th class="date">{{ __('Date') }}</th>
            <th class="title_translated">{{ __('Title') }}</th>
        </template>

        <template slot-scope="{ model }">
            <td>
                <input type="checkbox">
            </td>
            <td>
                @include('core::admin._button-edit', ['module' => 'news'])
            </td>
            <td>
                <typi-btn-status :model="model"></typi-btn-status>
            </td>
            <td>
                <img :src="model.thumb" alt="">
            </td>
            <td>@{{ model.date | date }}</td>
            <td>@{{ model.title_translated }}</td>
        </template>

    </item-list>

</div>

@endsection
