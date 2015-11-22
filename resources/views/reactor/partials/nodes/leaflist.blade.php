<ul class="node-children">
@foreach($leafs as $leaf)
    @if($leaf->hasTranslation($locale))
    <li>
        @if($leaf->hides_children || $leaf->nodeType->hides_children)

            @if($leaf->home)
                <div class="node-icon node-home"><i class="icon-home"></i></div>
            @else
                <div class="node-icon node-hides-children"></div>
            @endif

            <a href="{{ route('reactor.contents.tree', $leaf->getKey()) }}">
                {{ $leaf->translate($locale)->title }}
            </a>
            {!! node_options_list($leaf) !!}
        @else

            @if($leaf->home)
                <div class="node-icon node-home"><i class="icon-home"></i></div>
            @else
                <div class="node-icon node-intersection"></div>
            @endif

            <a href="{{ route('reactor.contents.edit', [
            'id' => $leaf->getKey(),
            'source' => $leaf->translate($locale)->getKey()
        ]) }}">
                {{ $leaf->translate($locale)->title }}
            </a>
            {!! node_options_list($leaf) !!}
            @if(count($leaf->children))
                @include('partials.nodes.leaflist', ['leafs' => $leaf->children])
            @endif
        @endif
    </li>
    @endif
@endforeach
</ul>