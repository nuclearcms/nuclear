@extends('nodetypes.base_edit')

@section('content')
    @include('nodetypes.tabs', [
        'currentRoute' => 'reactor.nodetypes.nodes',
        'currentKey' => $nodetype->getKey()
    ])

    <div class="content-inner content-inner--xcompact">
        @include('nodes.sublist', ['locale' => null])
    </div>
@endsection