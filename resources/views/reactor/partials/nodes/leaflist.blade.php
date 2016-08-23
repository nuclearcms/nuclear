@foreach($leafs as $leaf)
    @if($leaf->isVisible() && $leaf->hasTranslation($locale))
    <li class="nodes-list__node" data-nodeid="{{ $leaf->getKey() }}">
        <div class="nodes-list__label">
            @if($leaf->home)
                <div class="node-icon node-icon--home"><i class="icon-home"></i></div>
            @else
                <div class="node-icon {{ ($leaf->hidesChildren()) ? 'node-icon--hides-children' : 'node-icon--intersection' }}"></div>
            @endif

            <a class="nodes-list__label-link" href="{{ $leaf->getDefaultEditUrl($locale) }}">
                {{ $leaf->translate($locale)->title }}
            </a>

            <div class="nodes-list__options">
                {!! tree_node_options($leaf) !!}
            </div>
        </div>

        @unless($leaf->hidesChildren())
            <ul class="node-children">
                @include('partials.nodes.leaflist', ['leafs' => $leaf->getPositionOrderedChildren()])
            </ul>
        @endunless
    </li>
    @endif
@endforeach