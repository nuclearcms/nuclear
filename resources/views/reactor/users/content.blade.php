@foreach($users as $profile)
    <tr class="content-item">
        <td class="content-item-thumbnail">
            {{ $profile->present()->thumbnail }}
        </td>
        <td>
            <a href="/reactor/users/{{ $profile->getKey() }}/edit">
                {{ $profile->present()->fullName }}
            </a>
        </td>
        <td class="content-column-hidden">
            <a href="mailto:{{ $profile->email }}">
                {{ $profile->email }}
            </a>
        </td>
        <td class="content-column-hidden">
            <a href="/reactor/users/groups/0/edit">
                {{ $profile->present()->joinedAt }}
            </a>
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="/reactor/users/{{ $profile->getKey() }}/edit">
                    <i class="icon-pencil"></i> {{ trans('users.edit') }}</a>
            </li>

            @if($profile->getKey() !== $user->getKey())
                <li>
                    {!! delete_form(
                        '/reactor/users/' . $profile->getKey(),
                        trans('users.delete')
                    ) !!}
                </li>
            @else
                <li class="disabled">
                    <i class="icon-trash"></i> {{ trans('users.delete') }}
                </li>
            @endif

        {!! content_options_close() !!}
    </tr>
@endforeach