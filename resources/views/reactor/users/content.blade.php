@foreach($users as $person)
    <tr class="content-item">
        <td class="content-item-thumbnail">
            {{ $person->present()->thumbnail }}
        </td>
        <td class="content-item-title">
            <a href="/reactor/users/{{ $person->getKey() }}/edit">
                {{ $person->present()->fullName }}
            </a>
        </td>
        <td class="content-column-hidden">
            <a href="mailto:{{ $person->email }}">
                {{ $person->email }}
            </a>
        </td>
        <td class="content-column-hidden">
            <a href="/reactor/users/groups/0/edit">
                {{ $person->present()->userGroup }}
            </a>
        </td>
        <td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-light">
                <li>
                    <a href="/reactor/users/{{ $user->getKey() }}/edit">
                        <i class="icon-pencil"></i> {{ trans('users.edit') }}</a>
                </li>
                <li>
                    <form action="/reactor/users/{{ $user->getKey() }}" method="POST">
                        {!! method_field('DELETE') !!}
                        {!! csrf_field() !!}
                        <button type="submit" class="option-delete">
                            <i class="icon-trash"></i> {{ trans('users.delete') }}
                        </button>
                    </form>
                </li>
            </ul>
        </td>
    </tr>
@endforeach