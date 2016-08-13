@foreach($roles as $role)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($role->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.roles.edit', $role->label, $role->getKey()) !!}
        </td>
        <td class="content-list__cell">
            {{ $role->name }}
        </td>

        {!! content_options('roles', $role->getKey()) !!}

    </tr>
@endforeach