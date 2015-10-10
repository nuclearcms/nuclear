@foreach($permissions as $permission)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td class="content-item-title">
            <a href="/reactor/permissions/{{ $permission->getKey() }}/edit">
                {{ $permission->name }}
            </a>
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="/reactor/permissions/{{ $permission->getKey() }}/edit">
                    <i class="icon-pencil"></i> {{ trans('users.edit_permission') }}</a>
            </li>
            <li>
                {!! delete_form(
                    '/reactor/permissions/' . $permission->getKey(),
                    trans('users.delete_permission')
                ) !!}
            </li>
        {!! content_options_close() !!}
    </tr>
@endforeach