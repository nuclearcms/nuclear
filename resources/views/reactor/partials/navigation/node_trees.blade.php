@foreach(locales() as $locale)
    <div class="nodes-list-container nodes-list-container--{{ $locale }}
    {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? 'nodes-list-container--active' : '' }}">
        @if(has_translated($leafs, $locale))
            <ul class="nodes-list">
                @include('partials.nodes.leaflist', ['locale' => $locale])
            </ul>
        @else
            <p class="nodes-list__no-results">
                {{ trans('nodes.no_nodes') }}
            </p>
        @endif
    </div>
@endforeach