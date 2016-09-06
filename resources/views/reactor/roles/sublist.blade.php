{!! content_table_open(true) !!}
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('roles.self')) }}
</th>
{!! content_table_middle() !!}

@if($roles->count())
    @foreach ($roles as $role)
        <tr class="content-list__row--body">

            <td class="content-list__cell">
                {!! link_to_route('reactor.roles.edit', $role->label, $role->getKey()) !!}
            </td>

            {!! content_options_open() !!}
            <li class="dropdown-sub__item dropdown-sub__item--delete">
                {!! delete_form(
                    route('reactor.users.roles.dissociate', $user->getKey()),
                    trans('roles.dissociate'),
                    '<input type="hidden" name="role" value="' . $role->name . '">',
                    true
                ) !!}
            </li>
            {!! content_options_close() !!}

        </tr>
    @endforeach
@else
    {!! no_results_row('roles.no_roles') !!}
@endif

{!! content_table_close(true) !!}