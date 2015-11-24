@if(locale_count() > 1)
    <div class="translation-tabs">
        <ul class="content-tabs-bar secondary-tabs-bar node-tab-flaps">
            @foreach(config('translatable.locales') as $locale)
                <li class="content-tab-flap {!! (session('reactor.tree_locale', config('app.locale')) === $locale) ? 'active' : '' !!}"
                    data-for="{{ $locale }}"
                >{{ uppercase($locale) }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="nodes-subtree-container">
    <div id="navigation-nodes-sub-whiteout" class="navigation-nodes-whiteout"></div>

    <div id="navigation-nodes-sub-content" class="navigation-nodes-content" data-localeurl="{{ route('reactor.contents.locale') }}" data-sorturl="{{ route('reactor.contents.sort') }}">

        @foreach(config('translatable.locales') as $locale)
            <div class="nodes-list-tab nodes-list-{{ $locale }} {{ (session('reactor.tree_locale', config('app.locale')) === $locale) ? 'active' : '' }}">
                @if($node->hasTranslatedChildren($locale))
                    <ul class="nodes-list" id="nodes-sublist-{{ $locale }}">
                        @include('partials.nodes.leaflist', [
                            'locale' => $locale,
                            'leafs' => $nodes
                        ])
                    </ul>
                @else
                    <div class="content-message">
                        {{ trans('nodes.no_children') }}
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>

@section('scripts')
    <script>
        var subTreeNavigation = new TreeNavigation(
            $('#navigation-nodes-sub-content'),
            $('#navigation-nodes-sub-whiteout')
        );
    </script>
@endsection