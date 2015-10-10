<div class="content-list-container content-list-sub-container">
    <table class="content-list content-list-sub">
        <thead class="content-header">
        <tr>
            <th>{{ uppercase(trans('users.user')) }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="content-body">
        @if($users->count())
            @foreach ($users as $profile)
                <tr class="content-item">
                    <td>
                        <a href="/reactor/users/{{ $profile->getKey() }}/edit">
                            {{ $profile->present()->fullName }}
                        </a>
                    </td>
                    <td class="content-item-options">
                        <button class="content-item-options-button">
                            <i class="icon-ellipsis-vert"></i>
                        </button>
                        <ul class="content-item-options-list material-middle">
                            <li class="list-header">{{ uppercase(trans('general.options')) }}</li>
                            <li>
                                {!! delete_form(
                                    '/reactor/roles/' . $role->getKey() . '/users',
                                    trans('users.unlink_user')
                                ) !!}
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        @else
            {!! no_results_row('users.no_users') !!}
        @endif
        </tbody>
    </table>
</div>