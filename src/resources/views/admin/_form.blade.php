@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@endsection

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
                {!! BootForm::date(trans('validation.attributes.date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker') !!}
            </div>
        </div>

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-galleries">

        @include('core::admin._galleries-fieldset')

    </div>

</div>

