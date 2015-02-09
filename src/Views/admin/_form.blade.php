@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-galleries" data-target="#tab-galleries" data-toggle="tab">@lang('global.Galleries')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::date(trans('validation.attributes.date'), 'date')->value($model->present()->dateOrNow('date'))->placeholder(trans('validation.attributes.DDMMYYYY'))->addClass('datepicker') !!}
            </div>
        </div>


        @include('core::admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
                @include('core::form._title-and-slug')
                {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
                {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->addClass('editor')->rows(4) !!}
                {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('editor') !!}
            </div>

        @endforeach

        </div>

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-galleries">

        @include('core::admin._galleries-fieldset')

    </div>

</div>

