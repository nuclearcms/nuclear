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

        <div id="childTreeWhiteout" class="navigation-nodes-blackout children-tree-whiteout"></div>

        <div class="node-trees-container node-trees-container--sub" data-parentid="{{ $node->getKey() }}">
        @foreach(locales() as $locale)
            <div class="nodes-list-container nodes-list-container--{{ $locale }}
            {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? 'nodes-list-container--active' : '' }}">
                @if($node->hasTranslatedChildren($locale))
                    <ul class="nodes-list">
                        @include('partials.nodes.leaflist', ['locale' => $locale, 'leafs' => $node->getPositionOrderedChildren()])
                    </ul>
                @else
                    <p class="content-message">
                        {{ trans('nodes.no_nodes') }}
                    </p>
                @endif
            </div>
        @endforeach
        </div>
    </div>

    <div class="form-buttons form-buttons--displaced" id="formButtons">
        {!! action_button(route('reactor.nodes.create', $node->getKey()), 'icon-plus') !!}
    </div>
@endsection