@foreach($nodeTypes as $nodeType)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.nodes.edit', $nodeType->name, $nodeType->getKey()) !!}
        </td>
        <td>
            {{ $nodeType->label }}
        </td>
        {!! content_options_open() !!}
        <li>
            <a href="{{ route('reactor.nodes.edit', $nodeType->getKey()) }}">
                <i class="icon-pencil"></i> {{ trans('nodes.edit_type') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.nodes.destroy', $nodeType->getKey()),
                trans('nodes.delete_type')
            ) !!}
        </li>
        {!! content_options_close() !!}
    </tr>
@endforeach