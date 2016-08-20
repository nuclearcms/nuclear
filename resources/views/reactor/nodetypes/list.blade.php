@foreach($nodetypes as $nodetype)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($nodetype->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.nodetypes.edit', $nodetype->name, $nodetype->getKey()) !!}
        </td>
        <td class="content-list__cell">
            {{ $nodetype->label }}
        </td>

        {!! content_options('nodetypes', $nodetype->getKey()) !!}

    </tr>
@endforeach