<div class="content-list-container content-list-sub-container">
    <table class="content-list content-list-sub">
        <thead class="content-header">
        <tr>
            <th>{{ uppercase(trans('users.permission')) }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="content-body">
            @if($permissions->count())
                @foreach ($permissions as $permission)
                    <tr class="content-item">
                        <td>
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
                                    <form action="/reactor/roles/{{ $role->getKey() }}/permissions" method="POST">
                                        {!! method_field('DELETE') !!}
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="permission" value="{{ $permission->name }}">
                                        <button type="submit" class="option-delete">
                                            <i class="icon-trash"></i> {{ trans('users.unlink_permission') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="42" class="content-noresults">
                        {{ trans('users.no_permissions') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>