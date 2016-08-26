@extends('nodes.base_edit')

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

    <div class="content-inner{{ (locale_count() > 1) ? ' content-inner--xcompact' : '' }}">
        <div class="content-inner__options{{ (locale_count() > 1) ? ' content-inner__options--displaced' : '' }}">
            @include('nodes.options')
        </div>

        @include('nodes.sublist', ['nodes' => $children])
    </div>

    <div class="form-buttons form-buttons--displaced" id="formButtons">
        {!! action_button(route('reactor.nodes.create', $node->getKey()), 'icon-plus') !!}
    </div>
@endsection