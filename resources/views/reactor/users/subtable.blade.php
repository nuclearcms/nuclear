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
                                <form action="/reactor/roles/{{ $role->getKey() }}/users" method="POST">
                                    {!! method_field('DELETE') !!}
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="user" value="{{ $profile->getKey() }}">
                                    <button type="submit" class="option-delete">
                                        <i class="icon-trash"></i> {{ trans('users.unlink_user') }}
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
                    {{ trans('users.no_users') }}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>