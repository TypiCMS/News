@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{{ BootForm::hidden('id'); }}

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
            <div class="col-sm-6 form-group @if($errors->has('date'))has-error @endif">
                {{ Form::label('date', trans('validation.attributes.date'), array('class' => 'control-label')) }}
                {{ Form::text('date', $model->present()->dateOrNow(), array('class' => 'datepicker form-control', 'data-value' => $model->present()->dateOrNow(), 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
                {{ $errors->first('date', '<p class="help-block">:message</p>') }}
            </div>
            <div class="col-sm-3 form-group @if($errors->has('time'))has-error @endif">
                {{ Form::label('time', trans('validation.attributes.time'), array('class' => 'control-label')) }}
                {{ Form::text('time', $model->present()->timeOrNow(), array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
                {{ $errors->first('time', '<p class="help-block">:message</p>') }}
            </div>
        </div>


        @include('core::admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
                <div class="row">
                    <div class="col-md-6 form-group">
                        {{ BootForm::text(trans('labels.title'), $lang.'[title]') }}
                    </div>
                    <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                        {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                        <div class="input-group">
                            {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                            </span>
                        </div>
                        {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                    </div>
                </div>
                {{ BootForm::checkbox(trans('labels.online'), $lang.'[status]') }}
                <div class="form-group">
                    {{ Form::label($lang.'[summary]', trans('validation.attributes.summary')) }}
                    {{ Form::textarea($lang.'[summary]', $model->translate($lang)->summary, array('class' => 'form-control', 'rows' => 4)) }}
                </div>
                {{ BootForm::textarea(trans('labels.body'), $lang.'[body]')->addClass('editor') }}
            </div>

        @endforeach

        </div>

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-galleries">

        @include('core::admin._galleries-fieldset')

    </div>

</div>

