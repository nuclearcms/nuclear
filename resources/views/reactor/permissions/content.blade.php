@foreach($permissions as $permission)
    <tr class="content-list__row--body">
        <td class="content-list__cell content-list__cell--thumbnail">

        </td>
        <td class="content-list__cell">
            {!! link_to_route('reactor.permissions.edit', $permission->name, $permission->getKey()) !!}
        </td>

        {!! content_options_open() !!}
            <li class="dropdown-sub__item">
                <a href="{{ route('reactor.permissions.edit', $permission->getKey()) }}">
                    <i class="icon-pencil"></i>{{ trans('permissions.edit') }}</a>
            </li>
            <li class="dropdown-sub__item dropdown-sub__item--delete">
                {!! delete_form(
                    route('reactor.permissions.destroy', $permission->getKey()),
                    trans('permissions.destroy')
                ) !!}
            </li>
        {!! content_options_close() !!}

    </tr>
@endforeach