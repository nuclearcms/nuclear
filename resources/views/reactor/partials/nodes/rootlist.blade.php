<ul class="nodes-list node-tree">
@foreach($roots as $root)
    @if($root->hasTranslation($locale))
    <li class="node-root">
        @if($root->hides_children || $root->nodeType->hides_children)

            @if($root->home)
                <div class="node-icon node-home"><i class="icon-home"></i></div>
            @else
                <div class="node-icon node-hides-children"></div>
            @endif

            <a href="{{ route('reactor.contents.tree', $root->getKey()) }}">
                {{ $root->translate($locale)->title }}
            </a>
            {!! node_options_list($root) !!}
        @else

            @if($root->home)
                <div class="node-icon node-home"><i class="icon-home"></i></div>
            @else
                <div class="node-icon node-intersection"></div>
            @endif

            <a href="{{ route('reactor.contents.edit', [
                'id' => $root->getKey(),
                'source' => $root->translate($locale)->getKey()
            ]) }}">
                {{ $root->translate($locale)->title }}
            </a>
            {!! node_options_list($root) !!}
            @if($root->hasChildren())
                @include('partials.nodes.leaflist', ['leafs' => $root->children])
            @endif
        @endif
    </li>
    @endif
@endforeach
</ul>