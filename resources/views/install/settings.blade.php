@extends('layout.base')

@section('pageTitle', trans('install.site_settings'))

@section('body')
    <main class="dialog-container dialog-container--large">
        <div class="dialog dialog--large">
            @include('partials.progress', ['step' => 4])

            <div class="install text--center">
                <h1>@yield('pageTitle')</h1>

                @if($errors->count() > 0)
                <p class="text--sm text--danger">{{ trans('install.check_site_settings') }}</p>
                @else
                <p class="text--sm">{{ trans('install.enter_site_settings') }}</p>
                @endif

                <form action="{{ route('install-settings-post') }}" method="post" class="install-form">
                    {!! csrf_field() !!}

                    <div class="form-group form-group--inverted{{ $errors->has('base_url') ? ' form-group--error' : '' }}">
                        <label for="base_url" class="form-group__label{{ $errors->has('base_url') ? ' form-group__label--error' : '' }}">{{ trans('install.site_base_url') }}</label>
                        {!! Form::text('base_url', 'http://nuclear.app') !!}
                    </div>

                    <div class="form-group form-group--inverted{{ $errors->has('reactor_prefix') ? ' form-group--error' : '' }}">
                        <label for="reactor_prefix" class="form-group__label{{ $errors->has('reactor_prefix') ? ' form-group__label--error' : '' }}">{{ trans('install.reactor_prefix') }}</label>
                        {!! Form::text('reactor_prefix', 'reactor') !!}
                    </div>

                    <div class="modal-buttons">
                        <a href="{{ route('install-user') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('back')) }}</a>
                        <button type="submit" class="button button--emphasis">{{ uppercase(trans('install.site_information')) }} <i class="button__icon button__icon--right icon-arrow-right"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection