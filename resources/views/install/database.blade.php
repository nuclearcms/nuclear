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
                    'host' => 'localhost',
                    'port' => '3306',
                    'database' => 'nuclear',
                    'username' => 'homestead',
                    'password' => 'secret'
                ] as $field => $default)

                {!! field_wrapper_open([], $field, $errors, 'form-group--inverted') !!}
                    {!! field_label(true, ['label' => trans('install.' . $field)], $field, $errors) !!}
                    {!! Form::text($field, $default) !!}
                </div>

                @endforeach

                <div class="modal-buttons">
                    {!! action_button(route('install-welcome'), 'icon-arrow-left', trans('general.back'), '', 'l') !!}
                    {!! submit_button('icon-arrow-right', trans('install.user_information')) !!}
                </div>
            </form>

        </div>
    </div>
</main>
@endsection