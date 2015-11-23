<ul class="nodes-list" id="nodes-list-{{ $locale }}">
@foreach($roots as $root)
    @if($root->hasTranslation($locale))
    <li data-nodeid="{{ $root->getKey() }}">
        @if($root->hides_children || $root->nodeType->hides_children)
            <div class="node-label">
                @if($root->home)
                    <div class="drag-handle node-icon node-home"><i class="icon-home"></i></div>
                @else
                    <div class="drag-handle node-icon node-hides-children"></div>
                @endif

                <a href="{{ route('reactor.contents.tree', $root->getKey()) }}">
                    {{ $root->translate($locale)->title }}
                </a>
                {!! node_options_list($root) !!}
            </div>
        @else
            <div class="node-label">
                @if($root->home)
                    <div class="drag-handle node-icon node-home"><i class="icon-home"></i></div>
                @else
                    <div class="drag-handle node-icon node-intersection"></div>
                @endif

                <a href="{{ route('reactor.contents.edit', [
                    'id' => $root->getKey(),
                    'source' => $root->translate($locale)->getKey()
                ]) }}">
                    {{ $root->translate($locale)->title }}
                </a>
                {!! node_options_list($root) !!}
            </div>

            @include('partials.nodes.leaflist', ['leafs' => $root->getPositionOrderedChildren()])
        @endif
    </li>
    @endif
@endforeach
</ul>