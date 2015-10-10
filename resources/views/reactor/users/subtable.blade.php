{!! content_table_open(true) !!}
    <th>{{ uppercase(trans('users.user')) }}</th>
{!! content_table_middle() !!}
    @if($users->count())
        @foreach ($users as $profile)
            <tr class="content-item">
                <td>
                    <a href="/reactor/users/{{ $profile->getKey() }}/edit">
                        {{ $profile->present()->fullName }}
                    </a>
                </td>
                {!! content_options_open() !!}
                    <li>
                        {!! delete_form(
                            '/reactor/roles/' . $role->getKey() . '/users',
                            trans('users.unlink_user')
                        ) !!}
                    </li>
                {!! content_options_close() !!}
            </tr>
        @endforeach
    @else
        {!! no_results_row('users.no_users') !!}
    @endif
{!! content_table_close(true) !!}