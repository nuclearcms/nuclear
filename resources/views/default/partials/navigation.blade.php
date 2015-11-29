<ul class="navigation-list">
    @foreach($home->getPublishedPositionOrderedChildren() as $child)
        @if($child->hasTranslation())
        <li>
            {!! link_to($child->node_name, $child->title) !!}
        </li>
        @endif
    @endforeach
</ul>
