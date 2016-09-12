@extends('dashboard.base_index')

@section('content')
    @include('dashboard.tabs', [
        'currentRoute' => 'reactor.dashboard.activity',
        'currentKey' => []
    ])

    <div class="content-inner content-inner--compact">
        @include('activities.list')
    </div>
@endsection