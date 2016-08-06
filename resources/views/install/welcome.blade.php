@extends('layout.base')

@section('pageTitle', trans('install.install_nuclear'))

@section('body')
<main class="dialog-container dialog-container--large">
    <div class="dialog dialog--large">
        @include('partials.progress', ['step' => 1])

        <div class="install text--center">
            <h1>@yield('pageTitle')</h1>

            {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo', 'install__logo') !!}

            @if(empty($missing))
                <p>{{ trans('install.welcome_to_nuclear') }}</p>
                <p class="text--xs">{{ trans('install.nuclear_will_be_configured') }}</p>

                <form action="{{ route('install-welcome-post') }}" method="post" class="install-form">
                    {!! csrf_field() !!}

                    <p class="text--sm">{{ trans('install.choose_language_and_timezone') }}</p>

                    <div class="form-group form-group--inverted">
                        <label for="language" class="form-group__label">{{ trans('validation.attributes.language') }}</label>

                        <div class="form-group__select">
                            {!! Form::select('language', Reactor\Install\InstallHelper::$locales, env('REACTOR_LOCALE', 'en')) !!}
                            <i class="icon-arrow-down"></i>
                        </div>
                    </div>

                    <div class="form-group form-group--inverted">
                        <label for="timezone" class="form-group__label">{{ trans('validation.attributes.timezone') }}</label>

                        <div class="form-group__select">
                            {!! Form::select('timezone', Reactor\Install\InstallHelper::$timezones, env('APP_TIMEZONE', 'Europe/Istanbul')) !!}
                            <i class="icon-arrow-down"></i>
                        </div>
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" class="button button--emphasis">{{ uppercase(trans('install.database')) }} <i class="button__icon button__icon--right icon-arrow-right"></i></button>
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