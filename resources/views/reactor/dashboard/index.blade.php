@extends('dashboard.base_index')

@include('partials.statistics.tabs')

@section('content')
    @include('dashboard.tabs', [
        'currentRoute' => 'reactor.dashboard',
        'currentKey' => []
    ])

    <div class="content-inner content-inner--plain content-inner--shadow-displaced">
        @include('partials.statistics.chart')

        Other tables here
    </div>
@endsection