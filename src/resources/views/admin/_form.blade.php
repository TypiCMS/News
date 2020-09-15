@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<file-manager></file-manager>
<file-field type="image" field="image_id" data="{{ $model->image }}"></file-field>
<files-field :init-files="{{ $model->files }}"></files-field>

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::date(__('Date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker')->required() !!}
    </div>
</div>

@include('core::form._title-and-slug')
<div class="form-group">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
