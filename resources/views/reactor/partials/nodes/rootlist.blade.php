<ul class="nodes-list">
@foreach($roots as $root)
    @if($root->hasTranslation($locale))
    <li class="node-root">
        <a href="{{ route('reactor.contents.edit', [
            'id' => $root->getKey(),
            'source' => $root->translate($locale)->getKey()
        ]) }}">
            {{ $root->translate($locale)->title }}
        </a>
        @if($root->hasChildren())
        @include('partials.nodes.leaflist', ['leafs' => $root->children])
        @endif
    </li>
    @endif
@endforeach
</ul>