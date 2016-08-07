@extends('layout.base')

@section('pageTitle', trans('install.user_information'))

@section('body')
<main class="dialog-container dialog-container--xl">
    <div class="dialog dialog--xl">
        @include('partials.progress', ['step' => 3])

        <div class="install text--center">
            <h1>@yield('pageTitle')</h1>

            <form action="{{ route('install-user-post') }}" method="post" class="install-form">
                {!! csrf_field() !!}

                @if($errors->count() > 0)
                <p class="text--sm text--danger">{{ trans('install.check_user_information') }}</p>
                @else
                <p class="text--sm">{{ trans('install.enter_user_information') }}</p>
                @endif

                @foreach([
                    'first_name',
                    'last_name',
                    'email'
                ] as $field)

                    {!! field_wrapper_open([], $field, $errors, 'form-group--inverted') !!}
                        {!! field_label(true, [], $field, $errors) !!}
                        {!! Form::text($field) !!}
                    </div>

                @endforeach

                {!! field_wrapper_open([], 'password', $errors, 'form-group--inverted') !!}
                    {!! field_label(true, [], 'password', $errors) !!}
                    {!! Form::password('password') !!}
                </div>

                {!! field_wrapper_open([], 'password_confirmation', $errors, 'form-group--inverted') !!}
                    {!! field_label(true, [], 'password_confirmation', $errors) !!}
                    {!! Form::password('password_confirmation') !!}
                </div>

                <div class="modal-buttons">
                    {!! action_button(route('install-database'), 'icon-arrow-left', trans('back'), '', 'l') !!}
                    {!! submit_button('icon-arrow-right', trans('install.site_settings')) !!}
                </div>
            </form>

        </div>
    </div>
</main>
@endsection