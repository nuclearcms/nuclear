@extends('layout.reactor')

@section('pageTitle', trans('advanced.manage'))
@section('contentSubtitle', uppercase(trans('advanced.title')))

@section('content')
    <div class="advanced-options content-form material-light">
        <section class="advanced-options-set">
            <h3 class="icon-cog">{{ trans('advanced.optimize') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.optimize_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.optimize_app'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.optimize'), '', true, trans('advanced.optimize_app')) !!}
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.cache_routes'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.cache.routes'), '', true, trans('advanced.cache_routes')) !!}
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.regenerate_key'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.key'), '', true, trans('advanced.regenerate_key')) !!}
            </div>
        </section>
        <section class="advanced-options-set">
            <h3 class="icon-box">{{ trans('advanced.backup') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.backup_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.create_backup'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.backup.create'), '', true, trans('advanced.create_backup')) !!}
            </div>

        </section>
        <section class="advanced-options-set">
            <h3 class="icon-trash">{{ trans('advanced.cleanup') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.cleanup_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_password_resets'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.clear.password'), '', true, trans('advanced.clear_password_resets')) !!}
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_views'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.clear.views'), '', true, trans('advanced.clear_views')) !!}
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_activities'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.clear.activity'), '', true, trans('advanced.clear_activities')) !!}
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_cache'), ['class' => 'control-label']) !!}
                {!! action_button(route('reactor.advanced.clear.cache'), '', true, trans('advanced.clear_cache')) !!}
            </div>
        </section>
    </div>

@endsection