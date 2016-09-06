@foreach($users as $user)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($user->getKey(), '<span class="navigation-user__avatar">' . $user->present()->avatar . '</span>') !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.users.edit', $user->present()->fullName, $user->getKey()) !!}
        </td>
        <td class="content-list__cell content-list__cell--secondary">
            <a href="mailto:{{ $user->email }}">
                {{ $user->email }}
            </a>
        </td>
        <td class="content-list__cell content-list__cell--secondary">
            {{ $user->present()->joinedAt }}
        </td>

        {!! content_options('users', $user->getKey()) !!}

    </tr>
@endforeach