<div id="navigation-nodes-whiteout" class="navigation-nodes-whiteout"></div>

<div class="navigation-nodes-container material-light">
    <div class="scroll-container-nodes">
        <div class="scroller-nodes">

            <div id="navigation-nodes-content" class="navigation-nodes-content" data-localeurl="{{ route('reactor.contents.locale') }}" data-sorturl="{{ route('reactor.contents.sort') }}">

                <form id="search-nodes" method="GET" action="{{ route('reactor.contents.search') }}">
                    <input type="search" name="q" id="keywords" placeholder="{{ trans('general.search') }}" required>
                    <label class="icon-label" for="keywords">
                        <i class="icon-search"></i>
                    </label>
                </form>

                <div class="nodes-header">
                    <h2>{{ trans('general.content') }}</h2>
                    <a href="{{ route('reactor.contents.create') }}">
                        <i class="icon-plus"></i>
                    </a>
                </div>

                <ul class="node-tabs">
                    @foreach(config('translatable.locales') as $locale)
                        <li
                            data-for="{{ $locale }}"
                            {!! (session('reactor.tree_locale', config('app.locale')) === $locale) ? 'class="active"' : '' !!}
                        >{{ $locale }}</li>
                    @endforeach
                </ul>

                @foreach(config('translatable.locales') as $locale)
                    <div class="nodes-list-tab nodes-list-{{ $locale }} {{ (session('reactor.tree_locale', config('app.locale')) === $locale) ? 'active' : '' }}">
                        @include('partials.nodes.rootlist', ['locale' => $locale])
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>