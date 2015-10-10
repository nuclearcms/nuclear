@foreach($roles as $role)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.roles.edit', $role->label, $role->getKey()) !!}
        </td>
        <td>
            {{ $role->name }}
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="{{ route('reactor.roles.edit', $role->getKey()) }}">
                    <i class="icon-pencil"></i> {{ trans('users.edit_role') }}</a>
            </li>
            <li>
                {!! delete_form(
                    route('reactor.roles.destroy', $role->getKey()),
                    trans('users.delete_role')
                ) !!}
            </li>
        {!! content_options_close() !!}
    </tr>
@endforeach