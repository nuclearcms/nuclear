{!! content_table_open(true) !!}
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('permissions.self')) }}
</th>
{!! content_table_middle() !!}

@if($permissions->count())
    @foreach ($permissions as $permission)
        <tr class="content-list__row--body">

            <td class="content-list__cell">
                {!! link_to_route('reactor.permissions.edit', $permission->name, $permission->getKey()) !!}
            </td>

            {!! content_options_open() !!}
            <li class="dropdown-sub__item dropdown-sub__item--delete">
                {!! delete_form(
                    $route,
                    trans('permissions.revoke'),
                    '<input type="hidden" name="permission" value="' . $permission->name . '">',
                    true
                ) !!}
            </li>
            {!! content_options_close() !!}

        </tr>
    @endforeach
@else
    {!! no_results_row('permissions.no_permissions') !!}
@endif

{!! content_table_close(true) !!}