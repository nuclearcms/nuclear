@extends('layout.reactor')

@section('pageSubtitle', uppercase(trans('update.title')))

@section('content')
    <div class="content-inner"
         id="updateIndicator"
         data-starturl="{{ route('reactor.update.download') }}"
         data-completeurl="{{ route('reactor.update.index') }}"
    >
        <h3 class="content-inner__heading content-inner__heading--success"><i id="updaterIcon" class="icon-sync animate-spin"></i> {{ trans('update.update_in_progress') }}</h3>

        <p id="updateMessage" class="content-inner__message">{{ trans('update.downloading_latest') }}</p>

        <div class="progress-bar">
            <div id="updateProgress" class="progress-bar__rail" style="width:3%"></div>
        </div>

    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/updater.js') !!}
@endsection