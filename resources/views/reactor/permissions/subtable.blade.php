{!! content_table_open(true) !!}
    <th>{{ uppercase(trans('users.permission')) }}</th>
{!! content_table_middle() !!}
    @if($permissions->count())
        @foreach ($permissions as $permission)
            <tr class="content-item">
                <td>
                    {!! link_to_route('reactor.permissions.edit', $permission->name, $permission->getKey()) !!}
                </td>
                {!! content_options_open() !!}
                    <li>
                        {!! delete_form(
                            route('reactor.roles.permission.remove', $role->getKey()),
                            trans('users.unlink_permission')
                        ) !!}
                    </li>
                {!! content_options_close() !!}
            </tr>
        @endforeach
    @else
        {!! no_results_row('users.no_permissions') !!}
    @endif
{!! content_table_close(true) !!}