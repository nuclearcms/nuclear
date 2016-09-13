@extends('nodes.base_edit')

@include('partials.statistics.tabs')

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.statistics',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner content-inner--plain content-inner--shadow-displaced">
        <div class="content-inner__options content-inner__options--displaced">
            @include('nodes.options')
        </div>

        @include('partials.statistics.chart')

    </div>
@endsection