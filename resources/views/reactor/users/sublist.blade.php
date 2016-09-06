{!! content_table_open(true) !!}
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('users.self')) }}
</th>
{!! content_table_middle() !!}

@if($users->count())
    @foreach ($users as $user)
        <tr class="content-list__row--body">

            <td class="content-list__cell">
                {!! link_to_route('reactor.users.edit', $user->present()->fullName, $user->getKey()) !!}
            </td>

            {!! content_options_open() !!}
            <li class="dropdown-sub__item dropdown-sub__item--delete">
                {!! delete_form(
                    route('reactor.roles.users.dissociate', $role->getKey()),
                    trans('users.dissociate'),
                    '<input type="hidden" name="user" value="' . $user->getKey() . '">',
                    true
                ) !!}
            </li>
            {!! content_options_close() !!}

        </tr>
    @endforeach
@else
    {!! no_results_row('users.no_users') !!}
@endif

{!! content_table_close(true) !!}