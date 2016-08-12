@foreach($permissions as $permission)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($permission->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.permissions.edit', $permission->name, $permission->getKey()) !!}
        </td>

        {!! content_options('permissions', $permission->getKey()) !!}

    </tr>
@endforeach