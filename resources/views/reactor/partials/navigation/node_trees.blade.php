@foreach(locales() as $locale)
    <div class="nodes-list-container nodes-list-container--{{ $locale }}
    {{ (session('reactor.tree_locale', app()->getLocale()) === $locale) ? 'nodes-list-container--active' : '' }}">
        <ul class="nodes-list" id="navigationNodesList-{{ $locale }}">
            @include('partials.nodes.leaflist', ['locale' => $locale])
        </ul>
    </div>
@endforeach