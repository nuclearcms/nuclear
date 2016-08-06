@extends('layout.base')

@section('pageTitle', trans('install.database'))

@section('body')
<main class="dialog-container dialog-container--xl">
    <div class="dialog dialog--xl">
        @include('partials.progress', ['step' => 2])

        <div class="install text--center">
            <h1>@yield('pageTitle')</h1>

            <form action="{{ route('install-database-post') }}" method="post" class="install-form">
                {!! csrf_field() !!}

                <p class="text--sm">{{ trans('install.set_database_configuration') }}</p>

                @foreach([
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'database' => 'nuclear',
                    'username' => 'homestead',
                    'password' => 'secret'
                ] as $field => $default)

                <div class="form-group form-group--inverted">
                    <label for="{{ $field }}" class="form-group__label">{{ trans('install.' . $field) }}</label>
                    {!! Form::text($field, $default) !!}
                </div>

                @endforeach

                <div class="modal-buttons">
                    <a href="{{ route('install-welcome') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('back')) }}</a>
                    <button type="submit" class="button button--emphasis">{{ uppercase(trans('install.user_information')) }} <i class="button__icon button__icon--right icon-arrow-right"></i></button>
                </div>
            </form>

        </div>
    </div>
</main>
@endsection