@foreach($roles as $role)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            <a href="/reactor/roles/{{ $role->getKey() }}/edit">
                {{ $role->label }}
            </a>
        </td>
        <td>
            {{ $role->name }}
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="/reactor/roles/{{ $role->getKey() }}/edit">
                    <i class="icon-pencil"></i> {{ trans('users.edit_role') }}</a>
            </li>
            <li>
                {!! delete_form(
                    '/reactor/roles/' . $role->getKey(),
                    trans('users.delete_role')
                ) !!}
            </li>
        {!! content_options_close() !!}
    </tr>
@endforeach