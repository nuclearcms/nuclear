@foreach($users as $profile)
    <tr class="content-item">
        <td class="content-item-thumbnail">
            {{ $profile->present()->thumbnail }}
        </td>
        <td class="content-item-title">
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
                {{ $profile->present()->userGroup }}
            </a>
        </td>
        <td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">
                <li class="list-header">{{ uppercase(trans('general.options')) }}</li>
                <li>
                    <a href="/reactor/users/{{ $profile->getKey() }}/edit">
                        <i class="icon-pencil"></i> {{ trans('users.edit') }}</a>
                </li>
                @if($profile->getKey() !== $user->getKey())
                    <li>
                        <form action="/reactor/users/{{ $profile->getKey() }}" method="POST">
                            {!! method_field('DELETE') !!}
                            {!! csrf_field() !!}
                            <button type="submit" class="option-delete">
                                <i class="icon-trash"></i> {{ trans('users.delete') }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="disabled">
                        <i class="icon-trash"></i> {{ trans('users.delete') }}
                    </li>
                @endif
            </ul>
        </td>
    </tr>
@endforeach