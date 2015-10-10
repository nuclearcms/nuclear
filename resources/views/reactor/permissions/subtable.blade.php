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
                        {!! content_options_open() !!}
                            <li>
                                {!! delete_form(
                                    '/reactor/roles/' . $role->getKey() . '/permissions',
                                    trans('users.unlink_permission')
                                ) !!}
                            </li>
                        {!! content_options_close() !!}
                    </tr>
                @endforeach
            @else
                {!! no_results_row('users.no_permissions') !!}
            @endif
        </tbody>
    </table>
</div>