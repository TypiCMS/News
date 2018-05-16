@push('js')
<script>

</script>
@endpush

@extends('core::admin.master')

@section('title', __('News'))

@section('content')

<div id="listItems">

    @include('core::admin._button-create', ['module' => 'news'])

    <h1>@lang('News')</h1>

    <div class="btn-toolbar">
        {{-- @include('core::admin._button-select') --}}
        {{-- @include('core::admin._button-actions') --}}
        @include('core::admin._lang-switcher-for-list')
    </div>

    <div class="table-responsive">

        <table class="table table-main">

            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th class="status">{{ __('Status') }}</th>
                    <th class="image">{{ __('Image') }}</th>
                    <th class="date">{{ __('Date') }}</th>
                    <th class="title_translated">{{ __('Title') }}</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="model in models">
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
                    <td>@{{ model.date }}</td>
                    <td>@{{ model.title_translated }}</td>
                </tr>
            </tbody>

        </table>

    </div>

</div>

@endsection
