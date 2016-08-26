@extends('nodetypes.base_edit')

@section('content')
    @include('nodetypes.tabs', [
        'currentRoute' => 'reactor.nodetypes.fields',
        'currentKey' => $nodetype->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('nodefields.sublist', ['fields' => $nodetype->getFields()])
    </div>

    <div class="form-buttons" id="formButtons">
        {!! action_button(route('reactor.nodefields.create', $nodetype->getKey()), 'icon-plus') !!}
    </div>
@endsection