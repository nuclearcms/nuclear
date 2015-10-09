@foreach($permissions as $permission)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td class="content-item-title">
            <a href="/reactor/permissions/{{ $permission->getKey() }}/edit">
                {{ $permission->name }}
            </a>
        </td>
        <td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">
                <li class="list-header">{{ uppercase(trans('general.options')) }}</li>
                <li>
                    <a href="/reactor/permissions/{{ $permission->getKey() }}/edit">
                        <i class="icon-pencil"></i> {{ trans('users.edit_permission') }}</a>
                </li>
                <li>
                    <form action="/reactor/permissions/{{ $permission->getKey() }}" method="POST">
                        {!! method_field('DELETE') !!}
                        {!! csrf_field() !!}
                        <button type="submit" class="option-delete">
                            <i class="icon-trash"></i> {{ trans('users.delete_permission') }}
                        </button>
                    </form>
                </li>
            </ul>
        </td>
    </tr>
@endforeach