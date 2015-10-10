@foreach($roles as $role)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td class="content-item-title">
            <a href="/reactor/roles/{{ $role->getKey() }}/edit">
                {{ $role->label }}
            </a>
        </td>
        <td>
            {{ $role->name }}
        </td>
        <td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">
                <li class="list-header">{{ uppercase(trans('general.options')) }}</li>
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
            </ul>
        </td>
    </tr>
@endforeach