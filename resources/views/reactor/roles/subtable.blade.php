{!! content_table_open(true) !!}
    <th>{{ uppercase(trans('users.role')) }}</th>
{!! content_table_middle() !!}
    @if($roles->count())
        @foreach ($roles as $role)
            <tr class="content-item">
                <td>
                    {!! link_to_route('reactor.roles.edit', $role->label, $role->getKey()) !!}
                </td>
                {!! content_options_open() !!}
                <li>
                    {!! delete_form(
                        $route,
                        trans('users.unlink_role'),
                        '<input type="hidden" name="role" value="' . $role->name . '">'
                    ) !!}
                </li>
                {!! content_options_close() !!}
            </tr>
        @endforeach
    @else
        {!! no_results_row('users.no_roles') !!}
    @endif
{!! content_table_close(true) !!}