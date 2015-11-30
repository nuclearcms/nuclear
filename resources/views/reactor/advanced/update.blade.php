@extends('layout.reactor')

@section('pageTitle', trans('advanced.update'))
@section('contentSubtitle', uppercase(trans('advanced.title')))

@section('content')
    <div class="advanced-options content-form material-light">

        @if($updateService->isNuclearCurrent())

            <section class="advanced-options-set">
                <h3 class="icon-check success">{{ trans('advanced.up_to_date') }}</h3>

                <p class="advanced-option-description">
                    {!! trans('advanced.up_to_date_description', ['version' => nuclear_version()]) !!}
                </p>
            </section>

        @else
            @include('advanced.update.sub')
        @endif

    </div>

@endsection