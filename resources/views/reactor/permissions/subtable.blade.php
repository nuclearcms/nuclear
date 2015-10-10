{!! content_table_open(true) !!}
    <th>{{ uppercase(trans('users.permission')) }}</th>
{!! content_table_middle() !!}
    @if($permissions->count())
        @foreach ($permissions as $permission)
            <tr class="content-item">
                <td>
                    <a href="/reactor/permissions/{{ $permission->getKey() }}/edit">
                        {{ $permission->name }}
                    </a>
                </td>
                {!! content_options_open() !!}
                    <li>
                        {!! delete_form(
                            '/reactor/roles/' . $role->getKey() . '/permissions',
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