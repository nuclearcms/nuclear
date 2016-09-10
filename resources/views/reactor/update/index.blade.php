@extends('layout.reactor')

@section('pageSubtitle', uppercase(trans('update.title')))

@section('content')
    <div class="content-inner">

        @if(!$updater->isNuclearCurrent())
            <div>
                <h3 class="content-inner__heading content-inner__heading--success"><i class="icon-status-published"></i> {{ trans('update.nuclear_is_up_to_date') }}</h3>
                <p class="content-inner__message">{{ trans('update.up_to_date_description', ['version' => nuclear_version()]) }}</p>
            </div>
        @else
            @include('update.description')
        @endif

    </div>
@endsection