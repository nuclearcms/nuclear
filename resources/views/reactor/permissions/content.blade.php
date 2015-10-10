@foreach($permissions as $permission)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.permissions.edit', $permission->name, $permission->getKey()) !!}
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="{{ route('reactor.permissions.edit', $permission->getKey()) }}">
                    <i class="icon-pencil"></i> {{ trans('users.edit_permission') }}</a>
            </li>
            <li>
                {!! delete_form(
                    route('reactor.permissions.destroy', $permission->getKey()),
                    trans('users.delete_permission')
                ) !!}
            </li>
        {!! content_options_close() !!}
    </tr>
@endforeach