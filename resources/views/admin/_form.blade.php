@push('js')
    <script type="module" src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script type="module" src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('News')])
    @include('core::admin._title', ['default' => __('New news')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">

    @include('core::admin._form-errors')

    <file-manager></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
    <files-field :init-files="{{ $model->files }}"></files-field>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::date(__('Date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker')->required() !!}
        </div>
    </div>

    @include('core::form._title-and-slug')
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>
    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
</div>
