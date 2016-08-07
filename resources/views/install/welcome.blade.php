@extends('layout.base')

@section('pageTitle', trans('install.install_nuclear'))

@section('body')
<main class="dialog-container dialog-container--large">
    <div class="dialog dialog--large">
        @include('partials.progress', ['step' => 1])

        <div class="install text--center">
            <h1>@yield('pageTitle')</h1>

            {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo', 'dialog__logo') !!}

            @if(empty($missing))
                <p>{{ trans('install.welcome_to_nuclear') }}</p>
                <p class="text--xs">{{ trans('install.nuclear_will_be_configured') }}</p>

                <form action="{{ route('install-welcome-post') }}" method="post" class="install-form">
                    {!! csrf_field() !!}

                    <p class="text--sm">{{ trans('install.choose_language_and_timezone') }}</p>

                    {!! field_wrapper_open([], 'language', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, [], 'language', $errors) !!}

                        <div class="form-group__select">
                            {!! Form::select('language', Reactor\Support\Install\InstallHelper::$locales, env('REACTOR_LOCALE', 'en')) !!}
                            <i class="icon-arrow-down"></i>
                        </div>
                    </div>

                    {!! field_wrapper_open([], 'language', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, [], 'timezone', $errors) !!}

                        <div class="form-group__select">
                            {!! Form::select('timezone', Reactor\Support\Install\InstallHelper::$timezones, env('APP_TIMEZONE', 'Europe/Istanbul')) !!}
                            <i class="icon-arrow-down"></i>
                        </div>
                    </div>

                    <div class="modal-buttons">
                        {!! submit_button('icon-arrow-right', trans('install.database')) !!}
                    </div>
                </form>
            @else
                <div class="install-message">
                    <p>{!! trans('install.requirements_not_matched') !!}</p>

                    <ul class="install-missing">
                    @foreach($missing as $requirement)
                        <li class="install-missing__item">{!! $requirement !!}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</main>
@endsection