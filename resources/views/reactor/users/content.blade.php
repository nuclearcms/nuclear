@foreach($users as $profile)
    <tr class="content-item">
        <td class="content-item-thumbnail">
            {{ $profile->present()->thumbnail }}
        </td>
        <td>
            {!! link_to_route('reactor.users.edit', $profile->present()->fullName, $profile->getKey()) !!}
        </td>
        <td class="content-column-hidden">
            <a href="mailto:{{ $profile->email }}">
                {{ $profile->email }}
            </a>
        </td>
        <td class="content-column-hidden">
            {{ $profile->present()->joinedAt }}
        </td>
        {!! content_options_open() !!}
            <li>
                <a href="{{ route('reactor.users.edit', $profile->getKey()) }}">
                    <i class="icon-pencil"></i> {{ trans('users.edit') }}</a>
            </li>

            @if($profile->getKey() !== $user->getKey())
                <li>
                    {!! delete_form(
                        route('reactor.users.destroy', $profile->getKey()),
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