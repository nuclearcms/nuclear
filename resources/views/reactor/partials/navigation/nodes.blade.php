<div class="navigation-column navigation-column--nodes{{ (locale_count() > 1) ? ' navigation-column--nodes-multilingual' : '' }}">

    <div id="navigationNodesBlackout" class="navigation-nodes-blackout"></div>

    @can('ACCESS_CONTENTS')

    <div class="nodes-header">
        <form class="nodes-search" method="GET" action="{{ route('reactor.nodes.search') }}">
            <input type="search" name="q" id="keywords" placeholder="{{ trans('nodes.search') }}..." required>
            <label class="nodes-search__label icon-label" for="keywords">
                <i class="icon-search"></i>
            </label>
        </form>

        <div class="nodes-heading">
            <h2 class="nodes-heading__title">{{ uppercase(trans('general.content')) }}</h2>
            <a class="nodes-heading__create" href="{{ route('reactor.nodes.create') }}">
                <i class="icon-plus"></i>
            </a>
        </div>

        @if(locale_count() > 1)
        <ul class="compact-tabs nodes-tabs">
            @foreach(locales() as $locale)
            <li class="compact-tabs__tab nodes-tabs__tab nodes-tabs__tab--{{ $locale }}
                {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? ' compact-tabs__tab--active' : '' }}"
                data-locale="{{ $locale }}"
            >{{ uppercase($locale) }}</li>
            @endforeach
        </ul>
        @endif
    </div>

    <div class="scroller scroller--nodes-lists node-trees-container node-trees-container--nav"
         id="navigationNodesTree"
         data-localeurl="{{ route('reactor.nodes.tree.locale') }}"
         data-sorturl="{{ route('reactor.nodes.tree.sort') }}"
         data-parentid="0">
        @include('partials.navigation.node_trees')
    </div>

    @endcan

</div>