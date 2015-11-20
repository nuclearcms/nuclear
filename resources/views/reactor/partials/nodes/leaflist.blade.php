<ul class="node-children">
@foreach($leafs as $leaf)
    @if($leaf->hasTranslation($locale))
    <li>
        <a href="{{ route('reactor.contents.edit', [
            'id' => $leaf->getKey(),
            'source' => $leaf->translate($locale)->getKey()
        ]) }}">
            {{ $leaf->translate($locale)->title }}
        </a>
    </li>
    @if($leaf->hasChildren())
        @include('partials.nodes.leaflist', ['leafs' => $leaf->children])
    @endif
    @endif
@endforeach
</ul>