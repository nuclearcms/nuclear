@extends('nodes.base_edit')

@section('tab_options')
    OPT
@endsection

@section('children_tabs')
    @include('partials.contents.tabs_translations', [
        'translatable' => $node,
        'translationRoute' => 'reactor.nodes.children.list'
    ])
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'children',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner content-inner--xcompact">
        @include('nodes.sublist', ['nodes' => $children])
    </div>
@endsection

@section('form_end')
    <div class="form-buttons" id="formButtons">
        {!! action_button(route('reactor.nodes.create', $node->getKey()), 'icon-plus') !!}
    </div>
@endsection