@extends('layout.reactor')

@section('pageTitle', trans('advanced.auto_update'))
@section('contentSubtitle', uppercase(trans('advanced.title')))

@section('content')
    <div class="advanced-options content-form material-light">

        <section class="advanced-options-set">
            <h3 class="icon-arrows-cw">{{ trans('advanced.update_in_progress') }}</h3>

            <div id="updater-progress-indicator"
                 class="updater-progress-indicator"
                 data-startroute="{{ route('reactor.advanced.update.download') }}">
                <p id="progress-message" class="progress-message">
                    {{ trans('advanced.downloading_latest') }}
                </p>

                <div class="updater-progress">
                    <div id="progress-bar" class="progress-bar"></div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/update.js') !!}
@endsection