<ul class="node-children">
@foreach($leafs as $leaf)
    @if($leaf->hasTranslation($locale))
    <li>
        <div class="node-intersection"></div>
        <a href="{{ route('reactor.contents.edit', [
            'id' => $leaf->getKey(),
            'source' => $leaf->translate($locale)->getKey()
        ]) }}">
            {{ $leaf->translate($locale)->title }}
        </a>
        @if(count($leaf->children))
            @include('partials.nodes.leaflist', ['leafs' => $leaf->children])
        @endif
    </li>
    @endif
@endforeach
</ul>