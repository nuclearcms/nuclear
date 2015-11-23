<ul class="node-children">
@foreach($leafs as $leaf)
    @if($leaf->hasTranslation($locale))
    <li data-nodeid="{{ $leaf->getKey() }}">
        @if($leaf->hides_children || $leaf->nodeType->hides_children)
            <div class="node-label">
                @if($leaf->home)
                    <div class="drag-handle node-icon node-home"><i class="icon-home"></i></div>
                @else
                    <div class="drag-handle node-icon node-hides-children"></div>
                @endif

                <a href="{{ route('reactor.contents.tree', $leaf->getKey()) }}">
                    {{ $leaf->translate($locale)->title }}
                </a>
                {!! node_options_list($leaf) !!}
            </div>
        @else
            <div class="node-label">
                @if($leaf->home)
                    <div class="drag-handle node-icon node-home"><i class="icon-home"></i></div>
                @else
                    <div class="drag-handle node-icon node-intersection"></div>
                @endif

                <a href="{{ route('reactor.contents.edit', [
                    'id' => $leaf->getKey(),
                    'source' => $leaf->translate($locale)->getKey()
                ]) }}">
                    {{ $leaf->translate($locale)->title }}
                </a>
                {!! node_options_list($leaf) !!}
            </div>

            @include('partials.nodes.leaflist', ['leafs' => $leaf->getPositionOrderedChildren()])
        @endif
    </li>
    @endif
@endforeach
</ul>