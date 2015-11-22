@foreach($nodes as $node)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.contents.edit', $node->title, $node->getKey()) !!}
        </td>
        <td>
            {{ $node->nodeType->label }}
        </td>
        {!! content_options_open() !!}
        <li>
            <a href="{{ route('reactor.contents.edit', $node->getKey()) }}">
                <i class="icon-pencil"></i> {{ trans('nodes.edit') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.contents.destroy', $node->getKey()),
                trans('nodes.delete')
            ) !!}
        </li>
        {!! content_options_close() !!}
    </tr>
@endforeach