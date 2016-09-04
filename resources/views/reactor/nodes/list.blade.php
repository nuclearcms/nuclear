@foreach($nodes as $node)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($node->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to($node->getDefaultEditUrl(), $node->getTitle()) !!}
        </td>

        <td class="content-list__cell content-list__cell--secondary">
            {{ $node->getNodeType()->label }}
        </td>

        <td class="content-list__cell">
            {{ $node->created_at->formatLocalized('%b %e, %Y') }}
        </td>

        @if($node->isMailing())
        {!! content_options('mailings', $node->getKey()) !!}
        @else
        {!! node_options($node) !!}
        @endif

    </tr>
@endforeach