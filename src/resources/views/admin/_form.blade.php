@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('Content')</a>
    </li>
    <li>
        <a href="#tab-galleries" data-target="#tab-galleries" data-toggle="tab">@lang('Galleries')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::date(__('Date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker') !!}
            </div>
        </div>

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-galleries">

        @include('core::admin._galleries-fieldset')

    </div>

</div>

