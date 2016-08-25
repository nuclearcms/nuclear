@extends('nodes.base_edit')

@section('children_tabs')
    @if(locale_count() > 1)
        <ul class="tabs">
            @foreach(locales() as $locale)
                <li class="tabs__flap">
                    <span
                        class="tabs__child-link tabs__nodes-tab tabs__nodes-tab--{{$locale}} {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? ' tabs__child-link--active' : '' }}"
                        data-locale="{{ $locale }}">
                        {{ uppercase($locale) }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

    OPT
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'children',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner content-inner--xcompact">
        <div id="childTreeWhiteout" class="navigation-nodes-blackout children-tree-whiteout"></div>

        <div class="node-trees-container node-trees-container--sub" data-parentid="{{ $node->getKey() }}">
        @foreach(locales() as $locale)
            <div class="nodes-list-container nodes-list-container--{{ $locale }}
            {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? 'nodes-list-container--active' : '' }}">
                <ul class="nodes-list nodes-list-sub" id="navigationNodesList-{{ $locale }}">
                    @include('partials.nodes.leaflist', ['locale' => $locale, 'leafs' => $node->getPositionOrderedChildren()])
                </ul>
            </div>
        @endforeach
        </div>
    </div>
@endsection

@section('form_end')
    <div class="form-buttons" id="formButtons">
        {!! action_button(route('reactor.nodes.create', $node->getKey()), 'icon-plus') !!}
    </div>
@endsection