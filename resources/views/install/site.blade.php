@extends('layout.base')

@section('pageTitle', trans('install.site_information'))

@section('body')
    <main class="dialog-container dialog-container--xl">
        <div class="dialog dialog--xl">
            @include('partials.progress', ['step' => 5])

            <div class="install text--center">
                <h1>@yield('pageTitle')</h1>

                @if($errors->count() > 0)
                <p class="text--sm text--danger">{{ trans('install.check_site_information') }}</p>
                @else
                <p class="text--sm">{{ trans('install.enter_site_information') }}</p>
                @endif

                <form action="{{ route('install-site-post') }}" method="post" class="install-form">
                    {!! csrf_field() !!}

                    <div class="form-group form-group--inverted{{ $errors->has('meta_title') ? ' form-group--error' : '' }}">
                        <label for="meta_title" class="form-group__label{{ $errors->has('meta_title') ? ' form-group__label--error' : '' }}">{{ trans('install.site_title') }}</label>
                        {!! Form::text('meta_title') !!}
                    </div>

                    <div class="form-group form-group--inverted{{ $errors->has('meta_keywords') ? ' form-group--error' : '' }}">
                        <label for="meta_keywords" class="form-group__label{{ $errors->has('meta_keywords') ? ' form-group__label--error' : '' }}">{{ trans('install.site_keywords') }}</label>
                        {!! Form::text('meta_keywords') !!}
                    </div>

                    <div class="form-group form-group--inverted{{ $errors->has('meta_description') ? ' form-group--error' : '' }}">
                        <label for="meta_description" class="form-group__label{{ $errors->has('meta_description') ? ' form-group__label--error' : '' }}">{{ trans('install.site_description') }}</label>
                        {!! Form::textarea('meta_description') !!}
                    </div>

                    <div class="form-group form-group--inverted{{ $errors->has('meta_author') ? ' form-group--error' : '' }}">
                        <label for="meta_author" class="form-group__label{{ $errors->has('meta_author') ? ' form-group__label--error' : '' }}">{{ trans('install.site_author') }}</label>
                        {!! Form::text('meta_author') !!}
                    </div>

                    <div class="modal-buttons">
                        <a href="{{ route('install-user') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('back')) }}</a>
                        <button type="submit" class="button button--emphasis">{{ uppercase(trans('install.complete')) }} <i class="button__icon button__icon--right icon-arrow-right"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection