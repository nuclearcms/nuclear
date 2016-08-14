@foreach($users as $profile)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($profile->getKey(), '<span class="navigation-user__avatar">' . $profile->present()->avatar . '</span>') !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.users.edit', $profile->present()->fullName, $profile->getKey()) !!}
        </td>
        <td class="content-list__cell content-list__cell--secondary">
            <a href="mailto:{{ $profile->email }}">
                {{ $profile->email }}
            </a>
        </td>
        <td class="content-list__cell content-list__cell--secondary">
            {{ $profile->present()->joinedAt }}
        </td>

        {!! content_options('users', $profile->getKey()) !!}

    </tr>
@endforeach