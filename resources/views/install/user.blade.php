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

                    <div class="form-group form-group--inverted{{ $errors->has($field) ? ' form-group--error' : '' }}">
                        <label for="{{ $field }}" class="form-group__label{{ $errors->has($field) ? ' form-group__label--error' : '' }}">{{ trans('validation.attributes.' . $field) }}</label>
                        {!! Form::text($field) !!}
                    </div>

                @endforeach

                <div class="form-group form-group--inverted{{ $errors->has('password') ? ' form-group--error' : '' }}">
                    <label for="password" class="form-group__label{{ $errors->has('password') ? ' form-group__label--error' : '' }}">{{ trans('validation.attributes.password') }}</label>
                    {!! Form::password('password') !!}
                </div>

                <div class="form-group form-group--inverted{{ $errors->has('password_confirmation') ? ' form-group--error' : '' }}">
                    <label for="password_confirmation" class="form-group__label{{ $errors->has('password_confirmation') ? ' form-group__label--error' : '' }}">{{ trans('validation.attributes.password_confirmation') }}</label>
                    {!! Form::password('password_confirmation') !!}
                </div>

                <div class="modal-buttons">
                    <a href="{{ route('install-database') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('back')) }}</a>
                    <button type="submit" class="button button--emphasis">{{ uppercase(trans('install.site_settings')) }} <i class="button__icon button__icon--right icon-arrow-right"></i></button>
                </div>
            </form>

        </div>
    </div>
</main>
@endsection