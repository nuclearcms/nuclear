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

                    {!! field_wrapper_open([], 'base_url', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.site_base_url')], 'base_url', $errors) !!}
                        {!! Form::text('base_url', 'http://nuclear.app') !!}
                    </div>

                    {!! field_wrapper_open([], 'reactor_prefix', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.reactor_prefix')], 'reactor_prefix', $errors) !!}
                        {!! Form::text('reactor_prefix', 'reactor') !!}
                    </div>

                    <div class="modal-buttons">
                        {!! action_button(route('install-user'), 'icon-arrow-left', trans('back'), '', 'l') !!}
                        {!! submit_button('icon-arrow-right', trans('install.site_information')) !!}
                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection