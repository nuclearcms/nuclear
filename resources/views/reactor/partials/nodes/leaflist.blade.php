@foreach($leafs as $leaf)
    @if($leaf->isVisible() && $leaf->hasTranslation($locale))
    <li data-nodeid="{{ $leaf->getKey() }}">
        <div class="node-label">
            @if($leaf->home)
                <div class="drag-handle node-icon node-home"><i class="icon-home"></i></div>
            @else
                <div class="drag-handle node-icon {{ ($leaf->hidesChildren()) ? 'node-hides-children' : 'node-intersection' }}"></div>
            @endif

            <a href="{{ $leaf->getDefaultLink($locale) }}">
                {{ $leaf->translate($locale)->title }}
            </a>
            {!! node_options_list($leaf) !!}
        </div>

        @unless($leaf->hidesChildren())
            <ul class="node-children">
            @include('partials.nodes.leaflist', ['leafs' => $leaf->getPositionOrderedChildren()])
            </ul>
        @endunless
    </li>
    @endif
@endforeach