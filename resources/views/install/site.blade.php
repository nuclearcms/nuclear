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

                    {!! field_wrapper_open([], 'meta_title', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.site_title')], 'meta_title', $errors) !!}
                        {!! Form::text('meta_title') !!}
                    </div>

                    {!! field_wrapper_open([], 'meta_keywords', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.site_keywords')], 'meta_keywords', $errors) !!}
                        {!! Form::text('meta_keywords') !!}
                    </div>

                    {!! field_wrapper_open([], 'meta_description', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.site_description')], 'meta_description', $errors) !!}
                        {!! Form::textarea('meta_description') !!}
                    </div>

                    {!! field_wrapper_open([], 'meta_author', $errors, 'form-group--inverted') !!}
                        {!! field_label(true, ['label' => trans('install.site_author')], 'meta_author', $errors) !!}
                        {!! Form::text('meta_author') !!}
                    </div>

                    <div class="modal-buttons">
                        {!! action_button(route('install-settings'), 'icon-arrow-left', trans('back'), '', 'l') !!}
                        {!! submit_button('icon-arrow-right', trans('install.complete')) !!}
                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection